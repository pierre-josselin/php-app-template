<?php
header("Content-Type: text/css");
?>
body {
    background-color: #fbfbfb;
}

table {
    white-space: nowrap;
}

.form {
    max-width: 550px;
}

.profile-picture {
    background-size: cover;
    background-position: center;
}

.btn-facebook {
    color: white;
    background-color: #4267b2;
}

.btn-facebook:hover {
    color: white;
    background-color: #2b4a88;
}

.btn-keyrock {
    color: white;
    background-color: #fbba16;
}

.btn-keyrock:hover {
    color: white;
    background-color: #e2a407;
}

.custom-file-input ~ .custom-file-label::after {
    content: <?= json_encode(ucfirst($localization->getText("browse"))) ?>;
}