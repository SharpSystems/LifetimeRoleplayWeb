<?php
session_start();
ini_set('display_errors', '0');
require_once(__DIR__ . "/config.php");
require_once(__DIR__ . "/settings.php");
require_once(__DIR__ . "/actions/discord_functions.php");

if (empty($_SESSION['logged_in']))
{
	header('Location: '.BASE_URL.'/actions/register.php');
    die();
}

if (empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}

// ACTION NOTIFICATIONS
if(isset($_GET['success']))
{
  $actionMessage = '<div class="alert alert-success alert-dismissible fade show" style="text-align: center; font-size: 18px;" role="alert">Action Successful!</div>';
}

$feedbacks = $pdo->query("SELECT * FROM feedback ORDER BY id DESC");
$feedbacks = $feedbacks->fetchAll();
$feedback_types = $pdo->query("SELECT * FROM feedback_type");
$feedback_types = $feedback_types->fetchAll();
$feedbackComments = $pdo->query("SELECT * FROM feedback_comments ORDER BY id ASC");
$feedbackComments = $feedbackComments->fetchAll();

function getCount($feedbackid, $voteType)
{
    global $pdo;
    $count = $pdo->query("SELECT COUNT(vote) FROM feedback_votes WHERE feedback_id = $feedbackid AND vote = $voteType ");

    return $count->fetchColumn();
}

if (json_decode(verify())->authorised == "true" || checkDomain() == false) {
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- CSS -->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/meanmenu.min.css">
        <link rel="stylesheet" href="assets/css/boxicons.min.css">
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

        <!--OPEN GRAPH FOR DISCORD RICH PRESENCE-->
        <meta property="og:type" content="website" />
        <meta property="og:url" content="<?php echo BASE_URL; ?>" />
        <meta property="og:title" content="<?php echo $serverName; ?>" />
        <meta property="og:description" content="Community Site By Hamz#0001">
        <meta name="theme-color" content="<?php echo $accentColor; ?>">

        <title><?php echo $serverName; ?> | Feedback</title>

        <link rel="icon" type="image/png" href="<?php echo $serverLogo; ?>">

        <style>
            .feedback_card:hover {
                background-color: rgba(0,0,0,0.5);
                cursor: pointer;
            }
        </style>
    </head>

    <body>

        <!-- NAVBAR -->
        <?php include "includes/navbar.inc.php"; ?>

        <!-- MAIN -->
        <div class="hero-banner-area" id="home">
            <div class="container">
                <div class="row justify-content-center">
                    <span class="main-section-title text-center">Feedback Board</span>
                </div>
            </div>
        </div>
        <input type="hidden" name="token" id="token" value="<?php echo $_SESSION['token'] ?? '' ?>">
        <section class="faq-area ptb-100 white-container">
            <div class="container">
            <?php if($actionMessage){echo $actionMessage;} ?>
                <div class="row text-center justify-content-center">
                    <div class="col-md-8">
                        <div class="login-form">
                            <div class="row">
                                <div class="col-md-3"></div>
                                <div class="col-md-6 p-3">
                                    <p class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#createSuggestion">Create a Suggestion</p>
                                </div>
                                <div class="modal fade" id="createSuggestion" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                        <div class="modal-body text-left">
                                            <h2 class="text-center" style="padding-top: 10px !important;">Create Suggestion</h2>
                                            <form action="actions/functions.php"  method="post">
                                                <div class="row">
                                                    <div class="form-group col-md-12">
                                                        <label for="suggestion_title">Title</label>
                                                        <input type="text" name="suggestion_title" class="form-control" placeholder="Eg. New Vehicle" required>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="suggestion_text">Description</label>
                                                        <textarea type="text" name="suggestion_text" class="form-control" placeholder="Eg. Link to vehicle."></textarea>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="suggestion_type">Type</label>
                                                        <select class="form-control" name="suggestion_type">
                                                            <?php
                                                            foreach($feedback_types as $row)
                                                            {
                                                                echo '<option value="'.$row['type'].'">'.$row['type'].'</options>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <hr>
                                                </div>
                                                <div class="text-center">
                                                    <button class="btn btn-outline-info" type="submit" name="create_suggestion">Create</button>
                                                </div>
                                            </form>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                if (isset($_GET['feedbackid']))
                                {
                                    $row_id = $_GET['feedbackid'];

                                    $stmt = $pdo->prepare("SELECT * FROM feedback WHERE id=?");
                                    $stmt->execute([$row_id]);
                                    $feedback = $stmt->fetchAll();
                                    foreach ($feedback as $row) {
                                        $title = $row['title'];
                                        $text = $row['text'];
                                        $status = $row['status'];
                                        $type = $row['type'];
                                        $user = $row['user'];
                                    }

                                    $stmt = $pdo->prepare("SELECT * FROM feedback_comments WHERE feedbackid=?");
                                    $stmt->execute([$row_id]);
                                    $comments = $stmt->fetchAll();

                                    $stmt = $pdo->prepare("SELECT * FROM cards WHERE feedbackid=?");
                                    $stmt->execute([$row_id]);
                                    $incards = $stmt->fetchAll();
                                    foreach($incards as $row)
                                    {
                                        $checkcards = $row['title'];
                                    }

                            echo '<div class="modal fade" id="commentsModal" tabindex="-1" role="dialog">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                        <div class="modal-body">
                                            <h3 class="text-center" style="padding-top: 10px !important;">'.$title.'</h3>


                                            <p class="text-muted">'.$text.'</p>
                                            <span class="badge badge-pill bg-dark" style="color: white;">'.$status.'</span>
                                            <span class="badge badge-pill bg-dark" style="color: white;">'.$type.'</span>';



                                            if ($_SESSION['boardperms'] == 1) {
                                                if (empty($checkcards)) {
                                                    echo '<br><br><button onClick="pushDevBoard(`'.$row_id.'`, `'.$title.'`, `'.$text.'`, `'.$type.'`)" class="btn btn-outline-info">Push to Development Board</button>';
                                                    if ($user == $_SESSION['discordid'] or $_SESSION['boardperms'] == 1) {
                                                        echo '<button class="btn btn-outline-danger m-2" onClick="deleteFeedback('.$row_id.')">Delete</button>';
                                                    }
                                                }
                                                else {
                                                    if ($user == $_SESSION['discordid'] or $_SESSION['boardperms'] == 1) {
                                                        echo '<br><br><button class="btn btn-outline-danger" onClick="deleteFeedback('.$row_id.')">Delete</button>';
                                                    }
                                                }
                                            }


                                            echo '<hr><div class="row">';

                                            if (!empty($comments))
                                            {
                                                foreach($comments as $row)
                                                {
                                                    $comment = $row['comment'];
                                                    $commentDiscordID = $row['discordid'];
                                                    $commentTimePosted = $row['timePosted'];

                                                    $stmt = $pdo->prepare("SELECT * FROM users WHERE discordid=?");
                                                    $stmt->execute([$commentDiscordID]);
                                                    $commentuser = $stmt->fetchAll();

                                                    foreach($commentuser as $row2)
                                                    {
                                                        $commentName = $row2['name'];
                                                        $commentAvatar = $row2['avatar'];
                                                    }

                                                    echo '
                                                            <div class="col-md-2" style="padding-bottom: 15px;">
                                                                <img class="rounded-circle" style="width: 50%; margin-left: auto; display: block; margin-right: auto;" src="'.$commentAvatar.'" alt="Avatar">
                                                            </div>

                                                            <div class="col-md-8" style="text-align: left !important; padding-bottom: 10px;">
                                                                '.$comment.'<br>

                                                                <span class="text-muted" style="font-size: 15px;">'.$commentName.' <i style="font-size: 12px; padding: 1em;"> '.$commentTimePosted.'</i></span>
                                                            </div>

                                                            ';

                                                    if ($_SESSION['boardperms'] == 1 OR $_SESSION['discordid'] == $commentDiscordID) {
                                                        echo '<div class="col-md-2">
                                                        <button class="btn btn-outline-danger" style="float: right;" onClick="deleteComment(`'.$row['id'].'`)"><i class="bi bi-trash"></i></button>
                                                        </div>';
                                                    }

                                                    echo '<hr><br>';

                                                }
                                            }
                                            else
                                            {
                                                echo '
                                                    <div class="col-md-12" style="text-align: center !important; padding: 30px;">
                                                        <p class="text-muted" style="font-style: italic;">There are no comments yet.</p>
                                                    </div>
                                                <hr><br>
                                                ';
                                            }

                                        echo '</div><div class="row">
                                                <div class="col-md-10 p-5">
                                                    <input type="text" name="comment" id="comment" class="form-control" placeholder="Leave a comment">
                                                </div>
                                                <div class="col-md-2" style="padding-top: 55px; padding-bottom: 20px;">
                                                    <button onClick="addComment('.$row_id.')" class="btn btn-info">Comment</button>
                                                </div>
                                              </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                                }
                                ?>
                            </div>
                            <table id="basic-datatable" data-order='[[ 0, "desc" ]]' class="table table-dark table-responsive nowrap text-center">
                                <thead>
                                    <tr>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td></td>
                                    </tr>
                                    <?php
                                    foreach($feedbacks as $row)
                                    {
                                        echo '<tr>
                                              <td>
                                              <div class="row">
                                                <div class="col-md-10 feedback_card" data-id="'.$row['id'].'"
                                                    <h4 style="font-size: 18px; padding-top: 10px;">'.$row['title'].'<i><span class="text-muted" style="font-size: 14px; padding-left: 10px;"> '.$row['timePosted'].'</span></i></h4>
                                                    <p class="text-muted">'.$row['text'].'</p>
                                                    <span class="badge badge-pill bg-dark" style="color: white;">'.$row['status'].'</span>
                                                    <span class="badge badge-pill bg-dark" style="color: white;">'.$row['type'].'</span>
                                                    <br>
                                                </div>
                                                <div class="col-md-2">
                                                    <a onclick="upVote('.$row['id'].')" class="btn btn-outline-light" style="margin: 10px; margin-top: 20px; width: 55px;"><i class="bi bi-arrow-up-short"></i>'.getCount($row['id'], 1).'</a>
                                                    <a onclick="downVote('.$row['id'].')" class="btn btn-outline-light" style="margin: 10px; width: 55px;"><i class="bi bi-arrow-down-short"></i>'. getCount($row['id'], 0) .'</a>
                                                </div>
                                              </div>
                                              </td>
                                              </tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <br>
        </section>

        <!-- FOOTER -->
        <?php include "includes/footer.inc.php"; ?>

        <!-- JS -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.bundle.min.js"></script>
        <script src="assets/js/owl.carousel.min.js"></script>
        <script src="assets/js/parallax.min.js"></script>
        <script src="assets/js/meanmenu.min.js"></script>
        <script src="assets/js/magnific-popup.min.js"></script>
        <script src="assets/js/fancybox.min.js"></script>
        <script src="assets/js/wow.min.js"></script>
        <script src="assets/js/main.js"></script>
        <script src="assets/js/datatables/jquery.dataTables.min.js"></script>
        <script src="assets/js/datatables/dataTables.bootstrap4.js"></script>
        <script src="assets/js/datatables/dataTables.responsive.min.js"></script>
        <script src="assets/js/datatables/responsive.bootstrap4.min.js"></script>
        <script src="assets/js/datatables/dataTables.buttons.min.js"></script>
        <script src="assets/js/datatables/buttons.bootstrap4.min.js"></script>
        <script src="assets/js/datatables/buttons.html5.min.js"></script>
        <script src="assets/js/datatables/buttons.flash.min.js"></script>
        <script src="assets/js/datatables/buttons.print.min.js"></script>
        <script src="assets/js/datatables/dataTables.keyTable.min.js"></script>
        <script src="assets/js/datatables/dataTables.select.min.js"></script>
        <script src="assets/js/datatables.init.js"></script>
        <script type="text/javascript">
            function upVote(id)
            {
                $.ajax({
                    url: 'actions/functions.php',
                    type: 'POST',
                    data: {upvote: true, id: id},
                    success: function(data)
                    {
                        location.reload();
                    }
                });
            }

            function downVote(id)
            {
                $.ajax({
                    url: 'actions/functions.php',
                    type: 'POST',
                    data: {downvote: true, id: id},
                    success: function(data)
                    {
                        location.reload();
                    }
                });
            }

            function deleteComment(id)
            {
                $.ajax({
                    url: 'actions/functions.php',
                    type: 'POST',
                    data: {deleteComment: true, type: "feedback", id: id},
                    success: function(data)
                    {
                        location.reload();
                    }
                });
            }

            function deleteFeedback(id)
            {
                console.log(id);
                $.ajax({
                    url: 'actions/functions.php',
                    type: 'POST',
                    data: {deleteFeedback: true, id: id},
                    success: function(data)
                    {
                        location.replace('<?php echo BASE_URL; ?>/feedback.php');
                    }
                });
            }

            $(".feedback_card").on('click', function(event){

                var id = $(this).data('id');
                window.location.href = "feedback.php?feedbackid=" + id;
            });

            $(window).on('load',function(){
                $('#commentsModal').modal('show');
            });

            function addComment(id)
            {
                $.ajax({
                    url: 'actions/functions.php',
                    type: 'POST',
                    data: {addcomment: id, type: "feedback", comment: document.getElementById("comment").value, token : document.getElementById("token").value},
                    success: function(res)
                    {
                        location.reload();
                    }
                });
            }

            function pushDevBoard(id, title, text, type)
            {
                $.ajax({
                    url: 'actions/functions.php',
                    type: 'POST',
                    data: {pushtoboard: id, cardtitle: title, cardtext: text, cardtype: type, token : document.getElementById("token").value},
                    success: function(data)
                    {
                        location.reload();
                    }
                });
            }

            $('#commentsModal').on('hidden.bs.modal', function () {
            location.replace('<?php echo BASE_URL; ?>/feedback.php');
        })
        </script>
    </body>
</html>
<?php
} else {
    echo "";
}
?>