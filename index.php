<?php

session_start();

include "classes/PDOConnection.php";
include "classes/User.php";
include "classes/Api.php";

if (isset($_SESSION['admin'])) {
    $admin = $_SESSION['admin'];
}


?>

<!DOCTPYE html>
<html>
<head>
    <title>Backoffice</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="assets/style.css" rel="stylesheet">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

</head>
<body>

    <div id="wrapper" class="animate">
        <nav class="navbar header-top fixed-top navbar-expand-lg  navbar-dark bg-dark">
            <span class="navbar-toggler-icon leftmenutrigger"></span>
            <a class="navbar-brand" href="#"> &nbsp;VR_TOURISM Backoffice</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav animate side-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span class="sr-only">(current)</span>
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-md-auto d-md-flex">
                    <li class="nav-item">
                        <?php
                        if (isset($_SESSION['admin']) == 1){
                            ?>
                            <form method="post">
                                <button type="submit" name="deco" class="btn btn-primary">Déconnexion</button>
                            </form>
                        <?php } ?>

                    </li>
                </ul>
            </div>
        </nav>
    </div>

    <div class="container">

<?php
// si la connexion est réussite on rentre dans la condition
if (isset($admin) == 1) {

    $pdo = new PDOConnection();
    $lien = new Api($pdo);

    ?>
    <br><br>
    <div class="row">

        <br><br>
        <table class="table table-bordered table-striped">
            <thead>
            <tr class="bg-info ">
                <th></th>
                <th>Lien</th>
            </tr>
            </thead>
            <?php

            for ($i = 1; $i < $lien->countVideoLink() + 1; $i++) {

            ?>
                <tbody id="list-itens">


                <tr>
                    <td style="width:140px; text-align: center">
                        <input type="hidden" class="prop "id="id_link_<?php echo $i; ?>" value="<?php echo $i; ?>">
                        <button type="button" onclick="createEditor(<?php echo $i; ?>)" class="btn btn-warning">Edit</button>
                    </td>
                    <td>
                        <span id="editor_<?php echo $i; ?>"><?php echo $lien->getVideoLink($i) ?>
                            <button type="button" id="youEmbed" onclick="visioVideo(<?php echo $i ?>)" class="btn btn-danger">Visionner Video</button>
                        </span>

                        <div style="display:none;" id="editorLink_<?php echo $i; ?>">
                            <input type="text" id="video_link_<?php echo $i; ?>" name="video_link">
                            <button type="button" onclick="editLink(<?php echo $i; ?>)" class="btn btn-primary">Valider</button>
                        </div>
                    </td>
                </tr>

<!--                onclick="editLink(--><?php //echo $i; ?><!--)"-->

                </tbody>
            <?php } ?>

        </table>

        <div id="data_youtube"></div>

    </div>
    <br><br><br><br>
    <?php
} else {
    ?>
    <div class="row">
<!--    <div class="col-sm-6 col-sm-offset-3 text">-->

    <div id="logger" class="form-box">
        <div class="form-top">
            <div class="form-top-left">
                <h3>Formulaire de connexion</h3>
            </div>
            <div class="form-top-right">
                <i class="fa fa-pencil"></i>
            </div>
        </div>
        <div class="form-bottom">
            <form role="form" method="post" class="registration-form">
                <div class="form-group">
                    <label class="sr-only" for="form-first-name">Identifiant</label>
                    <input type="text" name="username" placeholder="Identifiant..." class="form-first-name form-control" id="form-first-name">
                </div>
                <div class="form-group">
                    <label class="sr-only" for="form-last-name">Mot de Passe</label>
                    <input type="password" name="password" placeholder="Mot de passe..." class="form-last-name form-control" id="form-last-name">
                </div>
                <br><br>
                <div class="form-group">
                    <button class="btn btn-primary" name="connect" type="submit">Connexion</button>
                    <br>
                    <!--<a class="btn btn-primary" href="forgotpassword.html" style="float:right;">Mot de passe oublié</a> -->
                </div>
            </form>
        </div>
    </div>
<!--</div>-->
    </div>
<?php
}
?>

<!-- END of container from header php -->
</div>
<footer class="footer">
    <div class="container">
        <span class="text-muted">&#9400; Copyright VR TOURISM <?php echo date('Y'); ?> </span>
    </div>
</footer>

</body>
</html>

<script>
    function createEditor(nb) {
        document.getElementById("editor_"+nb).style.display = "none";
        document.getElementById("editorLink_"+nb).style.display = "block";
    }

    // Connecteur AJAX
    function getXMLHttpRequest() {
        var xhr = null;

        if (window.XMLHttpRequest || window.ActiveXObject) {
            if (window.ActiveXObject) {
                try {
                    xhr = new ActiveXObject("Msxml2.XMLHTTP");
                } catch(e) {
                    xhr = new ActiveXObject("Microsoft.XMLHTTP");
                }
            } else {
                xhr = new XMLHttpRequest();
            }
        } else {
            alert("Votre navigateur ne supporte pas l'objet XMLHTTPRequest...");
            return null;
        }

        return xhr;
    }

    /**
     * Appel ajax permettant d'éditer les liens de connexions
     * @param nb
     */
    function editLink(nb) {
        var id = document.getElementById("id_link_"+nb).value;
        var videoLink = document.getElementById("video_link_"+nb).value;

        var xhr = getXMLHttpRequest();

        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
                document.getElementById("editorLink_"+nb).style.display = "none";
                document.getElementById("editor_"+nb).innerHTML = xhr.responseText;
                document.getElementById("editor_"+nb).style.display = "block";

            }
        };

        xhr.open("GET", "/pages/edit.php?id="+id+"&video_link="+videoLink, true);
        xhr.send(null);
    }

    /**
     * Appel permettant de visualiser une vidéo
     * @param nb
     */
    function visioVideo(nb) {
        var xhr = getXMLHttpRequest();

        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
                document.getElementById("data_youtube").innerHTML = xhr.responseText;
            }
        };

        xhr.open("GET", "/pages/youtube.php?id="+nb, true);
        xhr.send(null);
    }

</script>

<?php

if (isset($_POST['connect'])) {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    $pdo = new PDOConnection();
    $user = new User($pdo);

    $passwordVerify = $user->passwordVerifyConnection($username);

    if ($password == $passwordVerify) {
        $_SESSION['nom'] = $username;
        $_SESSION['admin'] = 1;
        header("Refresh:1; url=index.php");
    } else {
        echo '<br><br><div class="container"><div class="alert alert-danger" role="alert">
                <strong>Mauvais couple identifiant / Mot de Passe !! </strong> 
                <span>L\'utilisateur n\'a pas été hydraté par l\'administrateur</span>
            </div></div>';
    }
}

if (isset($_POST['deco'])) {
    session_destroy();
    header("Refresh:2; url=index.php");
}



