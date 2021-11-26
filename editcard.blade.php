<?php 
namespace App\Http\Controllers\Auth;
use Redirect;
use Session;
use Route;
use Illuminate\Support\Facades\Auth;
$con=mysqli_connect("localhost","roundwor_progiom","tHgv-3(19~pb","roundwor_progiom");


// GET LINK INFORMATIONS
if(isset($_GET['card'])){
    $card = $_GET['card'];
}else{
    return redirect()->away('https://roundworld-tr.com');
}

if(isset($_GET['userid'])){
    $userid = $_GET['userid'];
}else{
    return redirect()->away('https://roundworld-tr.com');
}


//GET USER ID

$auth = Auth::id();
if (empty($auth)){
    return redirect()->away('https://roundworld-tr.com');
}
// GET CARD INFORMATIONS
$sql = "SELECT * FROM nfc_cards WHERE cardnumber = '$card'";
$result = mysqli_query($con,$sql);
$row = mysqli_fetch_array($result);
if(empty($row['ID'])){
    return redirect()->away('https://roundworld-tr.com');
  }
$ID = $row['ID']; 
if($row['activatestatus'] == '1'){
    if($row['userid'] == $auth){ }else {
        return redirect()->away('https://roundworld-tr.com');
    } 
    
} else{ 
    if($row['userid'] == '0' || $row['userid'] == $auth){
        mysqli_query($con,"UPDATE nfc_cards SET userid = '$auth' WHERE cardnumber = '$card'");
        mysqli_query($con,"UPDATE nfc_cards SET activatestatus = '1' WHERE cardnumber = '$card'");
        mysqli_query($con,"UPDATE nfc_cards SET created_at = CURRENT_TIMESTAMP WHERE cardnumber = '$card'");
    } else{ 
        return redirect()->away('https://roundworld-tr.com');
    }
}


?>
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <input type="hidden" name="_token" value="{{ Session::token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ"
            crossorigin="anonymous"
        ></script>
        <script src="https://kit.fontawesome.com/419151a772.js" crossorigin="anonymous"></script>
        

        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU"
            crossorigin="anonymous"
        />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
        <link
     rel="stylesheet"
     href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
   
        <title>Flick | Edit Profile</title>
            <style>
                @import url('https://fonts.googleapis.com/css?family=Quicksand:400,500,700&subset=latin-ext');

                html {
                position: relative;
                overflow-x: hidden !important;
                }

                * {
                box-sizing: border-box;
                }

                body {
                font-family: 'Quicksand', sans-serif;
                color: #324e63;
                background-image: linear-gradient(-20deg, #28fff5 0%, #448fff 100%);
                }

                a,
                a:hover {
                text-decoration: none;
                color: #ffffff;
                }

                .icon {
                display: inline-block;
                width: 1em;
                height: 1em;
                stroke-width: 0;
                stroke: currentColor;
                fill: currentColor;
                }

                .wrapper {
                width: 100%;
                width: 100%;
                height: auto;
                min-height: 100vh;
                padding: 50px 20px;
                padding-top: 100px;
                display: flex;
                }

                .navbar {
                background-color: rgba(255, 255, 255, 0);
                }

                @media screen and (max-width: 768px) {
                .wrapper {
                height: auto;
                min-height: 100vh;
                padding-top: 100px;
                }
                }

                .profile-card {
                width: 100%;
                min-height: 460px;
                margin: auto;
                box-shadow: 0px 8px 60px -10px rgba(13, 28, 39, 0.6);
                background: #fff;
                border-radius: 35px;
                max-width: 700px;
                position: relative;
                }

                .profile-card.active .profile-card__cnt {
                filter: blur(6px);
                }

                .profile-card.active .profile-card-message,
                .profile-card.active .profile-card__overlay {
                opacity: 1;
                pointer-events: auto;
                transition-delay: 0.1s;
                }

                .profile-card.active .profile-card-form {
                transform: none;
                transition-delay: 0.1s;
                }

                .profile-card__img {
                width: 200px;
                height: 200px;
                margin-left: auto;
                margin-right: auto;
                transform: translateY(-50%);
                border-radius: 50%;
                overflow: hidden;
                position: relative;
                z-index: 4;
                box-shadow: 0px 5px 50px 0px #6c44fc, 0px 0px 0px 7px rgba(107, 74, 255, 0.5);
                }

                @media screen and (max-width: 576px) {
                .profile-card__img {
                width: 200px;
                height: 200px;
                }
                }

                .profile-card__img img {
                display: block;
                width: 100%;
                height: 100%;
                object-fit: cover;
                border-radius: 50%;
                }

                .profile-card__cnt {
                margin-top: -35px;
                text-align: center;
                padding: 0 20px;
                padding-bottom: 40px;
                transition: all 0.3s;
                }

                .profile-card__name {
                font-weight: 700;
                font-size: 24px;
                color: #6944ff;
                margin-bottom: 15px;
                }

                .profile-card__txt {
                font-size: 18px;
                font-weight: 500;
                color: #324e63;
                margin-bottom: 15px;
                word-wrap: break-word;
                }

                .profile-card__txt strong {
                font-weight: 700;
                }

                .profile-card-loc {
                display: flex;
                justify-content: center;
                align-items: center;
                font-size: 18px;
                font-weight: 600;
                }

                .profile-card-loc__icon {
                display: inline-flex;
                font-size: 27px;
                margin-right: 10px;
                }

                .profile-card-inf {
                display: flex;
                justify-content: center;
                flex-wrap: wrap;
                align-items: flex-start;
                margin-top: 35px;
                }

                .profile-card-inf__item {
                padding: 10px 35px;
                min-width: 150px;
                }

                @media screen and (max-width: 768px) {
                .profile-card-inf__item {
                padding: 10px 20px;
                min-width: 120px;
                }
                }

                .profile-card-inf__title {
                font-weight: 700;
                font-size: 20px;
                color: #324e63;
                }

                .profile-card-inf__txt {
                font-weight: 500;
                margin-top: 7px;
                }

                .profile-card-social {
                display: flex;
                justify-content: center;
                align-items: center;
                flex-wrap: wrap;
                }

                .profile-card-social__item {
                display: inline-flex;
                width: 89px;
                height: 89px;
                margin: 15px;
                border-radius: 30%;
                align-items: center;
                justify-content: center;
                color: #fff;
                background: #405de6;
                box-shadow: 0px 7px 30px rgba(43, 98, 169, 0.5);
                position: relative;
                font-size: 58px;
                flex-shrink: 0;
                transition: all 0.3s;
                }


                @media screen and (max-width: 768px) {
                .profile-card-social__item {
                width: 78px;
                height: 78px;
                margin: 10px;
                font-size: 48px;
                }
                }

                @media screen and (min-width: 768px) {
                .profile-card-social__item:hover {
                transform: scale(1.2);
                }
                }

                .profile-card-social__item.facebook {
        background: linear-gradient(45deg, #3b5998, #0078d7);
        box-shadow: 0px 4px 30px rgba(43, 98, 169, 0.5);
    }

    .profile-card-social__item.twitter {
        background: linear-gradient(45deg, #1da1f2, #0e71c8);
        box-shadow: 0px 4px 30px rgba(19, 127, 212, 0.7);
    }

    .profile-card-social__item.instagram {
        background: linear-gradient(45deg, #405de6, #5851db, #833ab4, #c13584, #e1306c, #fd1d1d);
        box-shadow: 0px 4px 30px rgba(120, 64, 190, 0.6);
    }

    .profile-card-social__item.behance {
        background: linear-gradient(45deg, #1769ff, #213fca);
        box-shadow: 0px 4px 30px rgba(27, 86, 231, 0.7);
    }

    .profile-card-social__item.github {
        background: linear-gradient(45deg, #333333, #626b73);
        box-shadow: 0px 4px 30px rgba(63, 65, 67, 0.6);
    }

    .profile-card-social__item.whatsapp {
        background: linear-gradient(45deg, #65cf0e, #459404);
        box-shadow: 0px 4px 30px rgba(13, 230, 67, 0.6);
    }

    .profile-card-social__item.linkedin {
        background: linear-gradient(45deg, #0084ff, #0084ff);
        box-shadow: 0px 4px 30px rgba(4, 118, 231, 0.6);
    }

    .profile-card-social__item.paypal {
        background: linear-gradient(45deg, #014caf, #0099ff);
        box-shadow: 0px 4px 30px rgba(0, 58, 248, 0.6);
    }

    .profile-card-social__item.snapchat {
        background: linear-gradient(45deg, #ffe600, #ffff00);
        box-shadow: 0px 4px 30px rgba(241, 245, 2, 0.6);
    }

    .profile-card-social__item.drive {
        background: linear-gradient(45deg, #ff006a, #0084ff);
    }

    .profile-card-social__item.email {
        background: linear-gradient(45deg, #ff006a, #0084ff);
    }

    .profile-card-social__item.papara {
        background: linear-gradient(45deg, #ff006a, #0084ff);
    }

    .profile-card-social__item.maps {
        background: linear-gradient(45deg, #0044ff, #00e1ff);
    }
    
    .profile-card-social__item.name {
        background: linear-gradient(45deg, #ff006a, #0084ff);
    }

    .profile-card-social__item.username {
        background: linear-gradient(45deg, #ff006a, #0084ff);
    }
    
    .profile-card-social__item.description {
        background: linear-gradient(45deg, #ff006a, #0084ff);
    }

    .profile-card-social__item.bank {
        background: linear-gradient(45deg, #ff006a, #545f69);
    }

    .profile-card-social__item.email {
        background: linear-gradient(45deg, #ff0000, #d6c806);
    }

    .profile-card-social__item.skype {
        background: linear-gradient(45deg, #0073c0, #2386dd);
        box-shadow: 0px 4px 30px rgba(0, 121, 241, 0.6);
    }

    .profile-card-social__item.spotify {
        background: linear-gradient(45deg, #10c246, #10c246);
        box-shadow: 0px 4px 30px rgba(56, 56, 56, 0.6);
    }


    .profile-card-social__item.telephone {
        background: linear-gradient(45deg, #10c246, #10c246);
        box-shadow: 0px 4px 30px rgba(56, 56, 56, 0.6);
    }

    .profile-card-social__item.steam {
        background: linear-gradient(45deg, #333333, #333333);
        box-shadow: 0px 4px 30px rgba(63, 65, 67, 0.6);
    }

    .profile-card-social__item.reddit {
        background: linear-gradient(45deg, #ff2f00, #f78c00);
        box-shadow: 0px 4px 30px rgba(255, 102, 0, 0.6);
    }

    .profile-card-social__item.tiktok {
        background: linear-gradient(45deg, #333333, #626b73);
        box-shadow: 0px 4px 30px rgba(63, 65, 67, 0.6);
    }
    

    .profile-card-social__item.twitch {
        background: linear-gradient(45deg, #9503f7, #a929ff);
        box-shadow: 0px 4px 30px rgba(159, 0, 252, 0.6);
    }
    .profile-card-social__item.telegram {
        background: linear-gradient(45deg, #014ec0, #136aee);
        box-shadow: 0px 4px 30px rgba(3, 126, 248, 0.6);
    }

    
    .profile-card-social__item.youtube {
        background: linear-gradient(45deg, #af0e0e, #c51818);
        box-shadow: 0px 4px 30px rgba(223, 45, 70, 0.6);
    }

    .profile-card-social__item.codepen {
        background: linear-gradient(45deg, #324e63, #414447);
        box-shadow: 0px 4px 30px rgba(55, 75, 90, 0.6);
    }

    .profile-card-social__item.link {
        background: linear-gradient(45deg, #d5135a, #f05924);
        box-shadow: 0px 4px 30px rgba(223, 45, 70, 0.6);
    }

                .profile-card-social .icon-font {
                display: inline-flex;
                }

                .profile-card-ctr {
                display: grid;
                justify-content: center;
                align-items: center;
                margin-top: -60px;
                text-align: center;
                }

                @media screen and (max-width: 576px) {
                .profile-card-ctr {
                flex-wrap: wrap;
                }
                }

                .input-card-ctr {
                display: grid;
                justify-content: center;
                align-items: center;
                margin-top: -60px;
                text-align: center;
                }

                @media screen and (max-width: 576px) {
                .input-card-ctr {
                flex-wrap: wrap;
                }
                }

                .profile-card__button {
                background: none;
                border: none;
                font-family: 'Quicksand', sans-serif;
                font-weight: 700;
                font-size: 19px;
                text-align: center;
                margin: 15px 35px;
                padding: 15px 40px;
                min-width: 201px;
                border-radius: 50px;
                min-height: 55px;
                color: #fff;
                cursor: pointer;
                backface-visibility: hidden;
                transition: all 0.3s;
                }

                @media screen and (max-width: 768px) {
                .profile-card__button {
                min-width: 170px;
                margin: 15px 25px;
                }
                }

                @media screen and (max-width: 576px) {
                .profile-card__button {
                min-width: inherit;
                margin: 0;
                margin-bottom: 16px;
                width: 100%;
                max-width: 250px;
                }

                .profile-card__button:last-child {
                margin-bottom: 0;
                }
                }

                .profile-card__button:focus {
                outline: none !important;
                }

                @media screen and (min-width: 768px) {
                .profile-card__button:hover {
                transform: translateY(-5px);
                }
                }

                .profile-card__button:first-child {
                margin-left: 0;
                }

                .profile-card__button:last-child {
                margin-right: 0;
                }

                .profile-card__button.button--blue {
                background: linear-gradient(45deg, #1da1f2, #0e71c8);
                box-shadow: 0px 4px 30px rgba(19, 127, 212, 0.4);
                }

                .profile-card__button.button--blue:hover {
                box-shadow: 0px 7px 30px rgba(19, 127, 212, 0.75);
                }

                .profile-card__button.button--orange {
                background: linear-gradient(45deg, #d5135a, #f05924);
                box-shadow: 0px 4px 30px rgba(223, 45, 70, 0.35);
                }

                .profile-card__button.button--green {
                    background: linear-gradient(45deg, #278b14, #22cf13);
                box-shadow: 0px 4px 30px rgba(45, 223, 45, 0.35);
                }

                .profile-card__button.button--blue {
                    background: linear-gradient(45deg, #143a8b, #1394cf);
                box-shadow: 0px 4px 30px rgba(45, 78, 223, 0.35);
                }

                .profile-card__button.button--blue:hover {
                box-shadow: 0px 7px 30px rgba(45, 143, 223, 0.75);
                }

                .profile-card__button.button--orange:hover {
                box-shadow: 0px 7px 30px rgba(223, 45, 70, 0.75);
                }

                .profile-card__button.button--green:hover {
                box-shadow: 0px 7px 30px rgba(45, 223, 69, 0.75);
                }

                .profile-card__button.button--gray {
                box-shadow: none;
                background: #dcdcdc;
                color: #142029;
                }

                .profile-card-message {
                width: 100%;
                height: 100%;
                position: absolute;
                top: 0;
                left: 0;
                padding-top: 130px;
                padding-bottom: 100px;
                opacity: 0;
                pointer-events: none;
                transition: all 0.3s;
                }

                .profile-card-form {
                box-shadow: 0 4px 30px rgba(15, 22, 56, 0.35);
                max-width: 80%;
                margin-left: auto;
                margin-right: auto;
                height: 100%;
                background: #fff;
                border-radius: 10px;
                padding: 35px;
                transform: scale(0.8);
                position: relative;
                z-index: 3;
                transition: all 0.3s;
                }

                @media screen and (max-width: 768px) {
                .profile-card-form {
                max-width: 90%;
                height: auto;
                }
                }

                @media screen and (max-width: 576px) {
                .profile-card-form {
                padding: 20px;
                }
                }

                .profile-card-form__bottom {
                justify-content: space-between;
                display: flex;
                }

                @media screen and (max-width: 576px) {
                    .profile-card-form__bottom {
                        flex-wrap: wrap;
                    }
                }

                .profile-card textarea {
                    width: 100%;
                    resize: none;
                    height: 127px;
                    margin-bottom: 20px;
                    border: 2px solid #dcdcdc;
                    border-radius: 10px;
                    padding: 15px 20px;
                    color: #324e63;
                    font-weight: 500;
                    font-family: 'Quicksand', sans-serif;
                    outline: none;
                    transition: all 0.3s;
                    text-align: center;
                }

                .profile-card textarea:focus {
                    outline: none;
                    border-color: #8a979e;
                }

                .profile-card__overlay {
                    width: 100%;
                    height: 100%;
                    position: absolute;
                    top: 0;
                    left: 0;
                    pointer-events: none;
                    opacity: 0;
                    background: rgba(22, 33, 72, 0.35);
                    border-radius: 12px;
                    transition: all 0.3s;
                }
                .button-wrapper{
                    position: relative;
                }

                /* Switch CSS */
                body .toggleWrapper {
                    position: absolute;
                    top: 13px;
                    right: 15px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    cursor: pointer;
                    transition: all 0.2s;
                    width: 25px;
                    height: 25px;
                    border-radius: 50%;
                    background-color: #fe4551;
                    box-shadow: 0 20px 20px 0 rgba(254, 69, 81, 0.3);
                    z-index: 10;
                    
                }

                body .toggleinput {
                    display: none;
                }
                body .toggleWrapper:active {
                    width: 30px;
                    height: 30px;
                    box-shadow: 0 15px 15px 0 rgba(254, 69, 81, 0.5);
                }
                body .toggleWrapper:active .toggle {
                    height: 7px;
                    width: 7px;
                }
                body .toggleWrapper .toggle {
                    transition: all 0.2s ease-in-out;
                    height: 5px;
                    width: 5px;
                    background-color: transparent;
                    border: 0px solid #fff;
                    border-radius: 50%;
                    cursor: pointer;
                    
                }
                body input:checked ~ .background {
                    background-color: #f9faf7;
                    font-family: "Font Awesome 5 Free"; content: "\f007";
                }
                body input:checked + .toggleWrapper {
                    background-color: #48e98a;
                    box-shadow: 0 20px 20px 0 rgba(72, 233, 138, 0.3);
                }
                body input:checked + .toggleWrapper:active {
                    box-shadow: 0 15px 15px 0 rgba(72, 233, 138, 0.5);
                }
                body input:checked + .toggleWrapper .toggle {
                    width: 0;
                    border-color: transparent;
                    border-radius: 30px;
                    animation: green 0.2s linear forwards !important;
                }

                @keyframes red {
                    0% {
                        height: 5px;
                        border-width: 7px;
                    }
                 
                    100% {
                        height: 10px;
                        border-width: 5px;
                    }
                }
                @keyframes green {
                    0% {
                        height: 20px;
                        width: 20px;
                        border-width: 10px;
                    }
                   
                    40%, 70%, 100% {
                        height: 10px;
                        width: 10px;
                        border-width: 5px;
                    }
                }

                .infoinput-center{
                    justify-content: center;
                    max-width:300px;
                    margin: auto;
                    padding-bottom: 30px;
                    padding-top: 20px;
                }



                .noselect {
  -webkit-touch-callout: none;
    -webkit-user-select: none;
     -khtml-user-select: none;
       -moz-user-select: none;
        -ms-user-select: none;
            user-select: none;
		-webkit-tap-highlight-color: transparent;
}

.buttonok {
	width: 38px;
	height: 38px;
	cursor: pointer;
	background-color: #5de6de;
	background-image: linear-gradient(315deg, #5de6de 0%, #b58ecc 74%);
	border: none;
	border-radius: 50%;
	transition: 200ms;
}

.loool {
	color: white;
    font-weight: 0;
	position: absolute;
    animation: bounce 2s infinite linear;
}


.buttonok:before {
	position: absolute;
	font-size: 15px;
	transition: 200ms;
	color: transparent;
	font-weight: bold;
}



.buttonok:hover::before {
	color: #fff;
}



@keyframes bounce {
	0% {transform: translateX(-50%) translateY(-50%)}
	25% {transform: translateX(-50%) translateY(-65%)}
	50% {transform: translateX(-50%) translateY(-50%)}
	75% {transform: translateX(-50%) translateY(-35%)}
	100% {transform: translateX(-50%) translateY(-50%)}
}

.buttonok:focus {
	outline: none;
}

h2 {
    margin-top: 40px;
    margin-bottom: 10px;
    text-align: center;
}

@media (max-width: 992px) {
    .navbar-collapse {
        position: absolute;
        top: 54px;
        left: 100%;
        padding-left: 15px;
        padding-right: 15px;
        padding-bottom: 15px;
        width: 100%;
        transition: all 0.4s ease;
        display: block;
    }
    .navbar-collapse.collapsing {
        height: auto !important;
        margin-left: 50%;
        left: 50%;
        transition: all 0.2s ease;
    }
    .navbar-collapse.show {
        left: 0;
    }
}


#snackbar {
  visibility: hidden;
  min-width: 250px;
  margin-left: -125px;
  background-color: #333;
  color: #fff;
  text-align: center;
  border-radius: 2px;
  padding: 16px;
  position: fixed;
  z-index: 1;
  left: 50%;
  bottom: 30px;
  font-size: 17px;
}

#snackbar.show {
  visibility: visible;
  -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
  animation: fadein 0.5s, fadeout 0.5s 2.5s;
}

@-webkit-keyframes fadein {
  from {bottom: 0; opacity: 0;} 
  to {bottom: 30px; opacity: 1;}
}

@keyframes fadein {
  from {bottom: 0; opacity: 0;}
  to {bottom: 30px; opacity: 1;}
}

@-webkit-keyframes fadeout {
  from {bottom: 30px; opacity: 1;} 
  to {bottom: 0; opacity: 0;}
}

@keyframes fadeout {
  from {bottom: 30px; opacity: 1;}
  to {bottom: 0; opacity: 0;}
}

            </style>
    </head>
    <body>
        <main>
            <div class="wrapper">
                <div class="profile-card js-profile-card">
                    <form action="https://roundworld-tr.com/uploadpicture.php" method="POST" enctype="multipart/form-data" >
                        <div class="profile-card__img">
                        <img class="img_profile" id="blah" src="<?php if(!empty($row['profileimage'])){echo "/profileimage/".$row['profileimage']; } else { echo "avatar.png";}?>">
                        </div>
                        <input type="text" value="<?php echo $card ?>" name="card" hidden>
                            <input type="text" value="<?php echo $userid ?>" id="userid" name="userid" hidden>
                            <input type="text" value="<?php echo $ID ?>" id="ID" name="ID" hidden>
                        <div class="profile-card-ctr" style="display:block">
                            
                            <label class="profile-card__button button--orange" style="margin-top: 24px;margin-bottom: 15px; width:auto">
                                @lang('auth.upload')<input name="profileimage" type="file" onchange="readURL(this);" hidden> 
                                </label>
                                <label class="profile-card__button button--green" style="margin-bottom: 15px;width:auto">
                                    @lang('auth.save')<input name="profileimage" type="submit" hidden> 
                                    </label>
                                </form>



                        </div>
                        <div class="infoinput-center">
                        <div class="input-group flex-nowrap" >
                            <span class="input-group-text" id="addon-wrapping"><i class="fas fa-user"></i></span>
                            <input type="text" class="form-control" value="<?php echo $row['name'];?>"  id="name" name="name" placeholder="Username" aria-label="Username" aria-describedby="addon-wrapping">
                        </div>
                            <textarea style="margin-top: 20px;margin-bottom: 10px;" id="description" name="description"><?php $desc = $row['description'];$x = preg_replace("/<br\W*?\/>/", "\n", $desc);echo htmlspecialchars($x);?></textarea>
                            <div class="input-group flex-nowrap" >
                            
                        </div></div>
                          

                        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                     <div class="profile-card-social">
                         <!-- Telephone Button -->
                         <div class="button-wrapper">
                            <!-- SWITCH -->
                                <a class="profile-card-social__item whatsapp" type="button" data-bs-toggle="modal" <?php if(empty($row['telephone']) ) {echo "style='-webkit-filter: grayscale(100%); filter: grayscale(100%);' ";}  ?>data-bs-target="#telephonemodal">
                                    <span class="icon-font">
                                        <i class="fas fa-phone-alt"></i>
                                    </span>
                                </a>
                         </div>
                            <!-- Telephone -->
                            <div class="modal fade" id="telephonemodal" tabindex="-1" aria-labelledby="telephonemodal" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title"     ><i class="fas fa-phone-alt"></i> | @lang('auth.phonenumber')</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input class="form-control"  value="<?php echo $row['telephone'];?>"  id="telephone" type="tel" name="telephone">
                                        
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" id='telephone_send' class="btn btn-primary">@lang('auth.save')</button>
                                    </div>
                                    </div>
                                </div>
                            </div>

 <!-- email Button -->
 <div class="button-wrapper">
    <!-- SWITCH -->
    <input class="toggleinput" type="checkbox" id="emailon" name="emailon" <?php if($row['emailon'] == 1) echo "checked"; ?>>
    <label for="emailon" class="toggleWrapper">
        <div class="toggle"></div>
    </label> 
<a class="profile-card-social__item email" type="button" data-bs-toggle="modal" <?php if(empty($row['email']) || $row['emailon'] == 0) {echo "style='-webkit-filter: grayscale(100%); filter: grayscale(100%);' ";}  ?>data-bs-target="#email">
    <span class="icon-font">
        <i class="fas fa-envelope"></i>
    </span>
</a>
</div>
<!-- email -->
<div class="modal  fade" id="email"     tabindex="-1" aria-labelledby="email" aria-hidden="true">
<div class="modal-dialog ">
<!-- Vertical center
<div class="modal-dialog modal-dialog modal-dialog-centered"> -->
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="email"><i class="fas fa-envelope"></i> | @lang('auth.email')</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <!-- INPUT GOES HERE -->
         <input class="form-control" value="<?php echo $row['email'];?>"  id="email" type='email' name="email">
    </div>
    <div class="modal-footer">
         
        <button type="button" id='email_send' class="btn btn-primary">@lang('auth.save')</button>
    </div>
    </div>
</div>
</div>

                         <!-- maps Button -->
                        <div class="button-wrapper">
                            <!-- SWITCH -->
                            <input class="toggleinput" type="checkbox" id="mapson" name="mapson" <?php if($row['mapson'] == 1) echo "checked"; ?>>
                            <label for="mapson" class="toggleWrapper">
                                <div class="toggle"></div>
                            </label> 
                        <a class="profile-card-social__item maps" type="button" data-bs-toggle="modal" <?php if(empty($row['maps']) || $row['mapson'] == 0) {echo "style='-webkit-filter: grayscale(100%); filter: grayscale(100%);' ";}  ?>data-bs-target="#maps">
                            <span class="icon-font">
                                <i class="fas fa-map-marked-alt"></i>
                            </span>
                        </a>
                        </div>
                        <!-- maps -->
                        <div class="modal  fade" id="maps"     tabindex="-1" aria-labelledby="maps" aria-hidden="true">
                        <div class="modal-dialog ">
                    <!-- Vertical center
                        <div class="modal-dialog modal-dialog modal-dialog-centered"> -->
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="maps"><i class="fas fa-map-marked-alt"></i> | @lang('auth.location')</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- INPUT GOES HERE -->
                                 <input class="form-control" value="<?php echo $row['maps'];?>"  id="maps" type='text' name="maps">

                                 <label class="profile-card__button button--green" style="display: grid; justify-content: center; align-items: center;">
                                    Get My Address<input name="profileimage" onclick="getLocation()" hidden> 
                                    </label>
                                 <p id="demo"></p>

                            </div>
                            <div class="modal-footer">
                                 
                                <button type="button" id='maps_send' class="btn btn-primary">@lang('auth.save')</button>
                            </div>
                            </div>
                        </div>
                    </div>

                     </div>
                     <h2>@lang('auth.socialmedia')</h2>
                     <div class="profile-card-social">
                        <!-- Whatsapp Button -->
                        <div class="button-wrapper">
                            <!-- SWITCH -->
                            <input class="toggleinput" type="checkbox" id="whatsappon" name="whatsappon" <?php if($row['whatsappon'] == 1) echo "checked"; ?>>
                            <label for="whatsappon" class="toggleWrapper">
                                <div class="toggle"></div>
                            </label> 

                                <a class="profile-card-social__item whatsapp" type="button" data-bs-toggle="modal" <?php if(empty($row['whatsapp']) || $row['whatsappon'] == 0) {echo "style='-webkit-filter: grayscale(100%); filter: grayscale(100%);' ";}  ?>data-bs-target="#whatsapp">
                                    <span class="icon-font">
                                        <i class="fab fa-whatsapp"></i>
                                    </span>
                                </a>
                            </div>
                            <!-- Whatsapp -->
                            <div class="modal fade" id="whatsapp"     tabindex="-1" aria-labelledby="whatsapp" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="whatsapp"><i class="fab fa-whatsapp"></i> | Whatsapp Number</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                        <input class="form-control"  value="<?php echo $row['whatsapp'];?>"  id="whatsapp" type="tel" name="whatsapp">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" id='whatsapp_send' class="btn btn-primary">@lang('auth.save')</button>
                                </div>
                                </div>
                            </div>
                        </div>
                        
                         <!-- facebook Button -->
                         <div class="button-wrapper">
                            <!-- SWITCH -->
                            <input class="toggleinput" type="checkbox" id="facebookon" name="facebookon" <?php if($row['facebookon'] == 1) echo "checked"; ?>>
                            <label for="facebookon" class="toggleWrapper">
                                <div class="toggle"></div>
                            </label> 
                            <a class="profile-card-social__item facebook" type="button" data-bs-toggle="modal" <?php if(empty($row['facebook']) || $row['facebookon'] == 0) {echo "style='-webkit-filter: grayscale(100%); filter: grayscale(100%);' ";}  ?>data-bs-target="#facebook">
                                <span class="icon-font">
                                    <i class="fab fa-facebook"></i>
                                </span>
                            </a>
                        </div>
                            <!-- facebook -->
                            <div class="modal  fade" id="facebook"     tabindex="-1" aria-labelledby="facebook" aria-hidden="true">
                            <div class="modal-dialog ">
                        <!-- Vertical center
                            <div class="modal-dialog modal-dialog modal-dialog-centered"> -->
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="facebook"><i class="fab fa-facebook"></i> | Facebook</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- INPUT GOES HERE -->
                                     <input class="form-control" value="<?php echo $row['facebook'];?>"  id="facebook" type='text' name="facebook">
                                </div>
                                <div class="modal-footer">
                                     
                                    <button type="button" id='facebook_send' class="btn btn-primary">@lang('auth.save')</button>
                                </div>
                                </div>
                            </div>
                        </div>

                         <!-- instagram Button -->
                            <div class="button-wrapper">
                                <!-- SWITCH -->
                                <input class="toggleinput" type="checkbox" id="instagramon" name="instagramon" <?php if($row['instagramon'] == 1) echo "checked"; ?>>
                                <label for="instagramon" class="toggleWrapper">
                                    <div class="toggle"></div>
                                </label> 
                        <a class="profile-card-social__item instagram" type="button" data-bs-toggle="modal" <?php if(empty($row['instagram']) || $row['instagramon'] == 0) {echo "style='-webkit-filter: grayscale(100%); filter: grayscale(100%);' ";}  ?>data-bs-target="#instagram">
                            <span class="icon-font">
                                <i class="fab fa-instagram"></i>
                            </span>
                        </a>
                            </div>
                        <!-- instagram -->
                        <div class="modal  fade" id="instagram"     tabindex="-1" aria-labelledby="instagram" aria-hidden="true">
                        <div class="modal-dialog ">
                    <!-- Vertical center
                        <div class="modal-dialog modal-dialog modal-dialog-centered"> -->
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="instagram"><i class="fab fa-instagram"></i> | Instagram</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- INPUT GOES HERE -->
                                 <input class="form-control" value="<?php echo $row['instagram'];?>"  id="instagram" type='text' name="instagram">
                            </div>
                            <div class="modal-footer">
                                 
                                <button type="button" id='instagram_send' class="btn btn-primary">@lang('auth.save')</button>
                            </div>
                            </div>
                        </div>
                    </div>

                       <!-- telegram Button -->
                        <div class="button-wrapper">
                            <!-- SWITCH -->
                            <input class="toggleinput" type="checkbox" id="telegramon" name="telegramon" <?php if($row['telegramon'] == 1) echo "checked"; ?>>
                            <label for="telegramon" class="toggleWrapper">
                                <div class="toggle"></div>
                            </label> 
                            <a class="profile-card-social__item telegram" type="button" data-bs-toggle="modal" <?php if(empty($row['telegram']) || $row['telegramon'] == 0) {echo "style='-webkit-filter: grayscale(100%); filter: grayscale(100%);' ";}  ?> data-bs-target="#telegramm">
                                <span class="icon-font">
                                    <i class="fab fa-telegram-plane"></i>
                                </span>
                            </a>
                    </div>
                            <!-- telegram -->
                            <div class="modal  fade" id="telegramm" tabindex="-1" aria-labelledby="telegramm" aria-hidden="true">
                            <div class="modal-dialog ">
                        <!-- Vertical center
                            <div class="modal-dialog modal-dialog modal-dialog-centered"> -->
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" ><i class="fab fa-telegram-plane"></i> | Telegram</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- INPUT GOES HERE -->
                                     <input class="form-control" value="<?php echo $row['telegram'];?>"  id="telegram" type='text' name="telegram">
                                </div>
                                <div class="modal-footer">
                                     
                                    <button type="button" id='telegram_send' class="btn btn-primary">@lang('auth.save')</button>
                                </div>
                                </div>
                            </div>
                        </div>
             

                         <!-- twitter Button -->
                         <div class="button-wrapper">
                            <!-- SWITCH -->
                            <input class="toggleinput" type="checkbox" id="twitteron" name="twitteron" <?php if($row['twitteron'] == 1) echo "checked"; ?>>
                            <label for="twitteron" class="toggleWrapper">
                                <div class="toggle"></div>
                            </label> 
                            <a class="profile-card-social__item twitter" type="button" data-bs-toggle="modal" <?php if(empty($row['twitter']) || $row['twitteron'] == 0) {echo "style='-webkit-filter: grayscale(100%); filter: grayscale(100%);' ";}  ?>data-bs-target="#twitter">
                                <span class="icon-font">
                                    <i class="fab fa-twitter"></i>
                                </span>
                            </a>
                    </div>
                            <!-- twitter -->
                            <div class="modal  fade" id="twitter"     tabindex="-1" aria-labelledby="twitter" aria-hidden="true">
                            <div class="modal-dialog ">
                        <!-- Vertical center
                            <div class="modal-dialog modal-dialog modal-dialog-centered"> -->
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="twitter"><i class="fab fa-twitter"></i> | Twitter</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- INPUT GOES HERE -->
                                     <input class="form-control" value="<?php echo $row['twitter'];?>"  id="twitter" type='text' name="twitter">
                                </div>
                                <div class="modal-footer">
                                     
                                    <button type="button" id='twitter_send' class="btn btn-primary">@lang('auth.save')</button>
                                </div>
                                </div>
                            </div>
                        </div>


                        <!-- tiktok Button -->
                        <div class="button-wrapper">
                            <!-- SWITCH -->
                            <input class="toggleinput" type="checkbox" id="tiktokon" name="tiktokon" <?php if($row['tiktokon'] == 1) echo "checked"; ?>>
                            <label for="tiktokon" class="toggleWrapper">
                                <div class="toggle"></div>
                            </label> 
                            <a class="profile-card-social__item tiktok" type="button" data-bs-toggle="modal" <?php if(empty($row['tiktok']) || $row['tiktokon'] == 0) {echo "style='-webkit-filter: grayscale(100%); filter: grayscale(100%);' ";}  ?>data-bs-target="#tiktok">
                                <span class="icon-font">
                                    <i class="fab fa-tiktok"></i>
                                </span>
                            </a>
                        </div>
                            <!-- tiktok -->
                            <div class="modal  fade" id="tiktok"     tabindex="-1" aria-labelledby="tiktok" aria-hidden="true">
                            <div class="modal-dialog ">
                        <!-- Vertical center
                            <div class="modal-dialog modal-dialog modal-dialog-centered"> -->
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="tiktok"><i class="fab fa-tiktok"></i> | Tiktok</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- INPUT GOES HERE -->
                                        <input class="form-control" value="<?php echo $row['tiktok'];?>"  id="tiktok" type='text' name="tiktok">
                                </div>
                                <div class="modal-footer">
                                        
                                    <button type="button" id='tiktok_send' class="btn btn-primary">@lang('auth.save')</button>
                                </div>
                                </div>
                            </div>
                        </div>


                        
                        <!-- twitch Button -->
                        <div class="button-wrapper">
                            <!-- SWITCH -->
                            <input class="toggleinput" type="checkbox" id="twitchon" name="twitchon" <?php if($row['twitchon'] == 1) echo "checked"; ?>>
                            <label for="twitchon" class="toggleWrapper">
                                <div class="toggle"></div>
                            </label> 
                            <a class="profile-card-social__item twitch" type="button" data-bs-toggle="modal" <?php if(empty($row['twitch']) || $row['twitchon'] == 0) {echo "style='-webkit-filter: grayscale(100%); filter: grayscale(100%);' ";}  ?>data-bs-target="#twitchh">
                                <span class="icon-font">
                                    <i class="fa fa-twitch"></i>
                                </span>
                            </a>
                    </div>
                            <!-- twitch -->
                            <div class="modal  fade" id="twitchh" tabindex="-1" aria-labelledby="twitch" aria-hidden="true">
                            <div class="modal-dialog ">
                        <!-- Vertical center
                            <div class="modal-dialog modal-dialog modal-dialog-centered"> -->
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="twitchh"><i class="fa fa-twitch"></i> | Twitch</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- INPUT GOES HERE -->
                                     <input class="form-control" value="<?php echo $row['twitch'];?>"  id="twitch" type='text' name="twitch">
                                </div>
                                <div class="modal-footer">
                                     
                                    <button type="button" id='twitch_send' class="btn btn-primary">@lang('auth.save')</button>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="button-wrapper">
                            <!-- SWITCH -->
                            <input class="toggleinput" type="checkbox" id="discordon" name="discordon" <?php if($row['discordon'] == 1) echo "checked"; ?>>
                            <label for="discordon" class="toggleWrapper">
                                <div class="toggle"></div>
                            </label> 
                        <a class="profile-card-social__item discord" type="button" data-bs-toggle="modal" <?php if(empty($row['discord']) || $row['discordon'] == 0) {echo "style='-webkit-filter: grayscale(100%); filter: grayscale(100%);' ";}  ?>data-bs-target="#discord">
                            <span class="icon-font">
                                <i class="fab fa-discord"></i>
                            </span>
                        </a>
                        </div>
                        <!-- discord -->
                        <div class="modal  fade" id="discord"     tabindex="-1" aria-labelledby="discord" aria-hidden="true">
                        <div class="modal-dialog ">
                    <!-- Vertical center
                        <div class="modal-dialog modal-dialog modal-dialog-centered"> -->
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="discord"><i class="fab fa-discord"></i> | Discord</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- INPUT GOES HERE -->
                                 <input class="form-control" value="<?php echo $row['discord'];?>"  id="discord" type='text' name="discord">
                            </div>
                            <div class="modal-footer">
                                 
                                <button type="button" id='discord_send' class="btn btn-primary">@lang('auth.save')</button>
                            </div>
                            </div>
                        </div>
                    </div>

<!-- steam Button -->
<div class="button-wrapper">
    <!-- SWITCH -->
    <input class="toggleinput" type="checkbox" id="steamon" name="steamon" <?php if($row['steamon'] == 1) echo "checked"; ?>>
    <label for="steamon" class="toggleWrapper">
        <div class="toggle"></div>
    </label> 
<a class="profile-card-social__item steam" type="button" data-bs-toggle="modal" <?php if(empty($row['steam']) || $row['steamon'] == 0) {echo "style='-webkit-filter: grayscale(100%); filter: grayscale(100%);' ";}  ?>data-bs-target="#steam">
    <span class="icon-font">
        <i class="fab fa-steam"></i>
    </span>
</a>
</div>
<!-- steam -->
<div class="modal  fade" id="steam"     tabindex="-1" aria-labelledby="steam" aria-hidden="true">
<div class="modal-dialog ">
<!-- Vertical center
<div class="modal-dialog modal-dialog modal-dialog-centered"> -->
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="steam"><i class="fab fa-steam"></i> | Steam</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <!-- INPUT GOES HERE -->
         <input class="form-control" value="<?php echo $row['steam'];?>"  id="steam" type='text' name="steam">
    </div>
    <div class="modal-footer">
         
        <button type="button" id='steam_send' class="btn btn-primary">@lang('auth.save')</button>
    </div>
    </div>
</div>
</div>

  <!-- youtube Button -->
  <div class="button-wrapper">
    <!-- SWITCH -->
    <input class="toggleinput" type="checkbox" id="youtubeon" name="youtubeon" <?php if($row['youtubeon'] == 1) echo "checked"; ?>>
    <label for="youtubeon" class="toggleWrapper">
        <div class="toggle"></div>
    </label> 
    <a class="profile-card-social__item youtube" type="button" data-bs-toggle="modal" <?php if(empty($row['youtube']) || $row['youtubeon'] == 0) {echo "style='-webkit-filter: grayscale(100%); filter: grayscale(100%);' ";}  ?>data-bs-target="#youtube">
        <span class="icon-font">
            <i class="fa fa-youtube"></i>
        </span>
    </a>
</div>
    <!-- youtube -->
    <div class="modal  fade" id="youtube"     tabindex="-1" aria-labelledby="youtube" aria-hidden="true">
    <div class="modal-dialog ">
<!-- Vertical center
    <div class="modal-dialog modal-dialog modal-dialog-centered"> -->
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="youtube"><i class="fa fa-youtube"></i> | Youtube</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <!-- INPUT GOES HERE -->
             <input class="form-control" value="<?php echo $row['youtube'];?>"  id="youtube" type='text' name="youtube">
        </div>
        <div class="modal-footer">
             
            <button type="button" id='youtube_send' class="btn btn-primary">@lang('auth.save')</button>
        </div>
        </div>
    </div>
</div>



                        <!-- spotify Button -->
                        <div class="button-wrapper">
                            <!-- SWITCH -->
                            <input class="toggleinput" type="checkbox" id="spotifyon" name="spotifyon" <?php if($row['spotifyon'] == 1) echo "checked"; ?>>
                            <label for="spotifyon" class="toggleWrapper">
                                <div class="toggle"></div>
                            </label> 
                            <a class="profile-card-social__item spotify" type="button" data-bs-toggle="modal" <?php if(empty($row['spotify']) || $row['spotifyon'] == 0) {echo "style='-webkit-filter: grayscale(100%); filter: grayscale(100%);' ";}  ?>data-bs-target="#spotify">
                                <span class="icon-font">
                                    <i class="fab fa-spotify"></i>
                                </span>
                            </a>
                    </div>
                            <!-- spotify -->
                            <div class="modal  fade" id="spotify"     tabindex="-1" aria-labelledby="spotify" aria-hidden="true">
                            <div class="modal-dialog ">
                        <!-- Vertical center
                            <div class="modal-dialog modal-dialog modal-dialog-centered"> -->
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="spotify"><i class="fab fa-spotify"></i> | Spotify</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- INPUT GOES HERE -->
                                     <input class="form-control" value="<?php echo $row['spotify'];?>"  id="spotify" type='text' name="spotify">
                                </div>
                                <div class="modal-footer">
                                     
                                    <button type="button" id='spotify_send' class="btn btn-primary">@lang('auth.save')</button>
                                </div>
                                </div>
                            </div>
                        </div>


                        <!-- snapchat Button -->
                        <div class="button-wrapper">
                            <!-- SWITCH -->
                            <input class="toggleinput" type="checkbox" id="snapchaton" name="snapchaton" <?php if($row['snapchaton'] == 1) echo "checked"; ?>>
                            <label for="snapchaton" class="toggleWrapper">
                                <div class="toggle"></div>
                            </label> 
                        <a class="profile-card-social__item snapchat" type="button" data-bs-toggle="modal" <?php if(empty($row['snapchat']) || $row['snapchaton'] == 0) {echo "style='-webkit-filter: grayscale(100%); filter: grayscale(100%);' ";}  ?>data-bs-target="#snapchat">
                            <span class="icon-font">
                                <i class="fab fa-snapchat-ghost"></i>
                            </span>
                        </a>
                    </div>
                        <!-- snapchat -->
                        <div class="modal  fade" id="snapchat"     tabindex="-1" aria-labelledby="snapchat" aria-hidden="true">
                        <div class="modal-dialog ">
                    <!-- Vertical center
                        <div class="modal-dialog modal-dialog modal-dialog-centered"> -->
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="snapchat"><i class="fab fa-snapchat-ghost"></i> | Snapchat</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- INPUT GOES HERE -->
                                 <input class="form-control" value="<?php echo $row['snapchat'];?>"  id="snapchat" type='text' name="snapchat">
                            </div>
                            <div class="modal-footer">
                                 
                                <button type="button" id='snapchat_send' class="btn btn-primary">@lang('auth.save')</button>
                            </div>
                            </div>
                        </div>
                    </div>



                    </div>
                    <h2>@lang('auth.privateaccounts')</h2>
                    <div class="profile-card-social">
                        <!-- bank Button -->
                            
                            



                        <!-- behance Button -->
                        <div class="button-wrapper">
                            <!-- SWITCH -->
                            <input class="toggleinput" type="checkbox" id="behanceon" name="behanceon" <?php if($row['behanceon'] == 1) echo "checked"; ?>>
                            <label for="behanceon" class="toggleWrapper">
                                <div class="toggle"></div>
                            </label> 
                        <a class="profile-card-social__item behance" type="button" data-bs-toggle="modal" <?php if(empty($row['behance']) || $row['behanceon'] == 0) {echo "style='-webkit-filter: grayscale(100%); filter: grayscale(100%);' ";}  ?>data-bs-target="#behance">
                            <span class="icon-font">
                                <i class="fa fa-behance"></i>
                            </span>
                        </a>
                        </div>
                        <!-- behance -->
                        <div class="modal  fade" id="behance"     tabindex="-1" aria-labelledby="behance" aria-hidden="true">
                        <div class="modal-dialog ">
                    <!-- Vertical center
                        <div class="modal-dialog modal-dialog modal-dialog-centered"> -->
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="behance"><i class="fa fa-behance"></i> | Behance </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- INPUT GOES HERE -->
                                 <input class="form-control" value="<?php echo $row['behance'];?>"  id="behance" type='text' name="behance">
                            </div>
                            <div class="modal-footer">
                                 
                                <button type="button" id='behance_send' class="btn btn-primary">@lang('auth.save')</button>
                            </div>
                            </div>
                        </div>
                    </div>


                        <!-- linkedin Button -->
                        <div class="button-wrapper">
                            <!-- SWITCH -->
                            <input class="toggleinput" type="checkbox" id="linkedinon" name="linkedinon" <?php if($row['linkedinon'] == 1) echo "checked"; ?>>
                            <label for="linkedinon" class="toggleWrapper">
                                <div class="toggle"></div>
                            </label> 
                            <a class="profile-card-social__item linkedin" type="button" data-bs-toggle="modal" <?php if(empty($row['linkedin']) || $row['linkedinon'] == 0) {echo "style='-webkit-filter: grayscale(100%); filter: grayscale(100%);' ";}  ?>data-bs-target="#linkedin">
                                <span class="icon-font">
                                    <i class="fab fa-linkedin"></i>
                                </span>
                            </a>
                    </div>
                            <!-- linkedin -->
                            <div class="modal  fade" id="linkedin"     tabindex="-1" aria-labelledby="linkedin" aria-hidden="true">
                            <div class="modal-dialog ">
                        <!-- Vertical center
                            <div class="modal-dialog modal-dialog modal-dialog-centered"> -->
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="linkedin"><i class="fab fa-linkedin"></i> | Linkedin</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- INPUT GOES HERE -->
                                     <input class="form-control" value="<?php echo $row['linkedin'];?>"  id="linkedin" type='text' name="linkedin">
                                </div>
                                <div class="modal-footer">
                                     
                                    <button type="button" id='linkedin_send' class="btn btn-primary">@lang('auth.save')</button>
                                </div>
                                </div>
                            </div>
                        </div>

                       
                        <!-- Website Button -->
                        <div class="button-wrapper">
                            <!-- SWITCH -->
                            <input class="toggleinput" type="checkbox" id="websiteon" name="websiteon" <?php if($row['websiteon'] == 1) echo "checked"; ?>>
                            <label for="websiteon" class="toggleWrapper">
                                <div class="toggle"></div>
                            </label> 

                            <a class="profile-card-social__item link" type="button" data-bs-toggle="modal" <?php if(empty($row['website']) || $row['websiteon'] == 0) {echo "style='-webkit-filter: grayscale(100%); filter: grayscale(100%);' ";}  ?>data-bs-target="#website">
                                <span class="icon-font">
                                    <i class="fa fa-globe"></i>
                                </span>
                            </a>
                        </div>
                            <!-- Website -->
                            <div class="modal  fade" id="website"     tabindex="-1" aria-labelledby="website" aria-hidden="true">
                            <div class="modal-dialog ">
                        <!-- Vertical center
                            <div class="modal-dialog modal-dialog modal-dialog-centered"> -->
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="website"><i class="fa fa-globe"></i> | @lang('auth.website')</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- INPUT GOES HERE -->
                                     <input placeholder="roundworld-tr.com" class="form-control" value="<?php echo $row['website'];?>"  id="website" type='text' name="website">
                                </div>
                                <div class="modal-footer">
                                     
                                    <button type="button" id='website_send' class="btn btn-primary">@lang('auth.save')</button>
                                </div>
                                </div>
                            </div>
                        </div>

                         <!-- drive Button -->
                         <div class="button-wrapper">
                            <!-- SWITCH -->
                            <input class="toggleinput" type="checkbox" id="driveon" name="driveon" <?php if($row['driveon'] == 1) echo "checked"; ?>>
                            <label for="driveon" class="toggleWrapper">
                                <div class="toggle"></div>
                            </label> 
                            <a class="profile-card-social__item drive" type="button" data-bs-toggle="modal" <?php if(empty($row['drive']) || $row['driveon'] == 0) {echo "style='-webkit-filter: grayscale(100%); filter: grayscale(100%);' ";}  ?>data-bs-target="#drive">
                                <span class="icon-font">
                                    <i class="fab fa-google-drive"></i>
                                </span>
                            </a>
                        </div>
                            <!-- drive -->
                            <div class="modal  fade" id="drive"     tabindex="-1" aria-labelledby="drive" aria-hidden="true">
                            <div class="modal-dialog ">
                        <!-- Vertical center
                            <div class="modal-dialog modal-dialog modal-dialog-centered"> -->
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="drive"><i class="fab fa-google-drive"></i> | Drive</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- INPUT GOES HERE -->
                                     <input class="form-control" value="<?php echo $row['drive'];?>"  id="drive" type='text' name="drive">
                                </div>
                                <div class="modal-footer">
                                     
                                    <button type="button" id='drive_send' class="btn btn-primary">@lang('auth.save')</button>
                                </div>
                                </div>
                            </div>
                        </div>
 <!-- reddit Button -->
 <div class="button-wrapper">
    <!-- SWITCH -->
    <input class="toggleinput" type="checkbox" id="redditon" name="redditon" <?php if($row['redditon'] == 1) echo "checked"; ?>>
    <label for="redditon" class="toggleWrapper">
        <div class="toggle"></div>
    </label> 
<a class="profile-card-social__item reddit" type="button" data-bs-toggle="modal" <?php if(empty($row['reddit']) || $row['redditon'] == 0) {echo "style='-webkit-filter: grayscale(100%); filter: grayscale(100%);' ";}  ?>data-bs-target="#reddit">
    <span class="icon-font">
        <i class="fab fa-reddit-alien"></i>
    </span>
</a>
</div>
<!-- reddit -->
<div class="modal  fade" id="reddit"     tabindex="-1" aria-labelledby="reddit" aria-hidden="true">
<div class="modal-dialog ">
<!-- Vertical center
<div class="modal-dialog modal-dialog modal-dialog-centered"> -->
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="reddit"><i class="fab fa-reddit-alien"></i> | Reddit</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <!-- INPUT GOES HERE -->
         <input class="form-control" value="<?php echo $row['reddit'];?>"  id="reddit" type='text' name="reddit">
    </div>
    <div class="modal-footer">
         
        <button type="button" id='reddit_send' class="btn btn-primary">@lang('auth.save')</button>
    </div>
    </div>
</div>
</div>



<!-- skype Button -->
<div class="button-wrapper">
    <!-- SWITCH -->
    <input class="toggleinput" type="checkbox" id="skypeon" name="skypeon" <?php if($row['skypeon'] == 1) echo "checked"; ?>>
    <label for="skypeon" class="toggleWrapper">
        <div class="toggle"></div>
    </label> 
    <a class="profile-card-social__item skype" type="button" data-bs-toggle="modal" <?php if(empty($row['skype']) || $row['skypeon'] == 0) {echo "style='-webkit-filter: grayscale(100%); filter: grayscale(100%);' ";}  ?>data-bs-target="#skype">
        <span class="icon-font">
            <i class="fab fa-skype"></i>
        </span>
    </a>
</div>
    <!-- skype -->
    <div class="modal  fade" id="skype"     tabindex="-1" aria-labelledby="skype" aria-hidden="true">
    <div class="modal-dialog ">
<!-- Vertical center
    <div class="modal-dialog modal-dialog modal-dialog-centered"> -->
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="skype"><i class="fab fa-skype"></i> | Skype</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <!-- INPUT GOES HERE -->
             <input class="form-control" value="<?php echo $row['skype'];?>"  id="skype" type='text' name="skype">
        </div>
        <div class="modal-footer">
             
            <button type="button" id='skype_send' class="btn btn-primary">@lang('auth.save')</button>
        </div>
        </div>
    </div>
</div>


                    </div>
                    <h2>@lang('auth.bankaccounts')</h2>
                    <div class="profile-card-social">

                            <!-- papara Button -->
                            <div class="button-wrapper">
                            <!-- SWITCH -->
                            <input class="toggleinput" type="checkbox" id="paparaon" name="paparaon" <?php if($row['paparaon'] == 1) echo "checked"; ?>>
                            <label for="paparaon" class="toggleWrapper">
                                <div class="toggle"></div>
                            </label> 
                            <a class="profile-card-social__item papara" type="button" data-bs-toggle="modal" <?php if(empty($row['papara']) || $row['paparaon'] == 0) {echo "style='-webkit-filter: grayscale(100%); filter: grayscale(100%);' ";}  ?>data-bs-target="#papara">
                                <span class="icon-font">
                                    <i class="fab fa-product-hunt"></i>
                                </span>
                            </a>
                    </div>
                            <!-- papara -->
                            <div class="modal  fade" id="papara"     tabindex="-1" aria-labelledby="papara" aria-hidden="true">
                            <div class="modal-dialog ">
                        <!-- Vertical center
                            <div class="modal-dialog modal-dialog modal-dialog-centered"> -->
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="papara"><i class="fab fa-product-hunt"></i> | Papara</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- INPUT GOES HERE -->
                                     <input class="form-control" value="<?php echo $row['papara'];?>"  id="papara" type='text' name="papara">
                                </div>
                                <div class="modal-footer">
                                     
                                    <button type="button" id='papara_send' class="btn btn-primary">@lang('auth.save')</button>
                                </div>
                                </div>
                            </div>
                        </div>

                        <div class="button-wrapper">
                            <!-- SWITCH -->
                            <input class="toggleinput" type="checkbox" id="bankon" name="bankon" <?php if($row['bankon'] == 1) echo "checked"; ?>>
                            <label for="bankon" class="toggleWrapper">
                                <div class="toggle"></div>
                            </label> 

                                <a class="profile-card-social__item bank" type="button" data-bs-toggle="modal" <?php if(empty($row['bank']) || $row['bankon'] == 0) {echo "style='-webkit-filter: grayscale(100%); filter: grayscale(100%);' ";}  ?>data-bs-target="#bank">
                                <span class="icon-font">
                                    <i class="fas fa-university"></i>
                                </span>
                            </a>
                        </div>
                            <!-- bank -->
                            <div class="modal  fade" id="bank"     tabindex="-1" aria-labelledby="bank" aria-hidden="true">
                            <div class="modal-dialog ">
                        <!-- Vertical center
                            <div class="modal-dialog modal-dialog modal-dialog-centered"> -->
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="bank"><i class="fas fa-university"></i> | @lang('auth.bankinfo')</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- INPUT GOES HERE -->
                                    <p style="margin-bottom:0px">@lang('auth.bank')</p>
                                    <input class="form-control" value="<?php echo $row['bank'];?>" placeholder="Ziraat Bank"  id="bank" type='text' name="bank" style="
                                    margin-bottom: 15px;">
                                    <p style="margin-bottom:0px">@lang('auth.bankname')</p>
                                    <input class="form-control" value="<?php echo $row['bankname'];?>"  id="bankname" placeholder="John Smith" type='text' name="bankname" style="
                                    margin-bottom: 15px;">
                                    <p style="margin-bottom:0px">@lang('auth.bankiban')</p>
                                    <input class="form-control" value="<?php echo $row['bankiban'];?>"  id="bankiban" placeholder="TR32 0010 0099 9990 1234 5678 90" type='text' name="bankiban" style="
                                    margin-bottom: 15px;">

                                    {{-- <label class="profile-card__button button--blue" style="display: block;margin-left: auto;margin-right: auto;margin-bottom: auto;margin-top:30px;width:auto">
                                        Add Another Bank<input name="profileimage" type="file" hidden> 
                                        </label> --}}
                                </div>
                                <div class="modal-footer">
                                     
                                    <button type="button" id='bank_send' class="btn btn-primary">@lang('auth.save')</button>
                                </div>
                                </div>
                            </div>
                        </div>


                        <!-- paypal Button -->
                        <div class="button-wrapper">
                            <!-- SWITCH -->
                            <input class="toggleinput" type="checkbox" id="paypalon" name="paypalon" <?php if($row['paypalon'] == 1) echo "checked"; ?>>
                            <label for="paypalon" class="toggleWrapper">
                                <div class="toggle"></div>
                            </label> 
                            <a class="profile-card-social__item paypal" type="button" data-bs-toggle="modal" <?php if(empty($row['paypal']) || $row['paypalon'] == 0) {echo "style='-webkit-filter: grayscale(100%); filter: grayscale(100%);' ";}  ?>data-bs-target="#paypal">
                                <span class="icon-font">
                                    <i class="fab fa-paypal"></i>
                                </span>
                            </a>
                    </div>
                            <!-- paypal -->
                            <div class="modal  fade" id="paypal"     tabindex="-1" aria-labelledby="paypal" aria-hidden="true">
                            <div class="modal-dialog ">
                        <!-- Vertical center
                            <div class="modal-dialog modal-dialog modal-dialog-centered"> -->
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="paypal"><i class="fab fa-paypal"></i> | Paypal</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- INPUT GOES HERE -->
                                     <input class="form-control" value="<?php echo $row['paypal'];?>"  id="paypal" type='text' name="paypal">
                                </div>
                                <div class="modal-footer">
                                     
                                    <button type="button" id='paypal_send' class="btn btn-primary">@lang('auth.save')</button>
                                </div>
                                </div>
                            </div>
                        </div>

                       

                        



                        
        </div>
<div style="display: grid; justify-content: center; align-items: center;">
        <label class="profile-card__button button--orange" id="goback" style="margin-bottom:20px; margin-top:30px">
            <a href="https://roundworld-tr.com/flick.php?card=<?php echo $card?>">@lang('auth.gotoprofile')</a>
            </label>

        </div>
                </div>
            </div>
        </main>
        <div id="snackbar">@lang('auth.updated')</div>
    </body>
</html>




<script>
    let btnsToggle = $('.toggleinput');
    $(btnsToggle).each(function(index, input){
        $(input).click(function(){
            const inputIsChecked = $(this).is(':checked');
            var ID = document.getElementById("ID").value;
            if(inputIsChecked){
                let on = $(this).attr("name");
                $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
             }
         });
          jQuery.ajax({
             url: "/cardedit-ajax/" + ID ,
             method: 'post',
             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
             data: { _token: $('#token').val(),
                        on: on,  },
             success: function(result){
                console.log(result);
             }});
            } else{
                let off = $(this).attr("name");
                $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
             }
         });
          jQuery.ajax({
             url: "/cardedit-ajax/" + ID ,
             method: 'post',
             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
             data: { _token: $('#token').val(),
                off: off,  },
                
             success: function(result){
                console.log(result);
             }
            });
            }
        });
    });
</script>


<script>
function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah')
                        .attr('src', e.target.result)
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
</script>
<script>
    var x = document.getElementById("demo");
    
    function getLocation() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
      } else { 
        x.innerHTML = "Geolocation is not supported by this browser.";
      }
    }

    ;
    function showPosition(position) {
      var location = "https://maps.google.com/?q=" + position.coords.latitude + "," + position.coords.longitude;
      $('input[name="maps"]').val(location);
      console.log(location);
    }
    </script>

<script>
    var phoneInputField = document.querySelector('input[name="whatsapp"]');
    var phoneInput = window.intlTelInput(phoneInputField, {
     preferredCountries: ["tr", "sy", "ae"],
      utilsScript:
        "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
    });
</script>
<script>
    var phoneInputField1 = document.querySelector('input[name="telephone"]');
    var phoneInput1 = window.intlTelInput(phoneInputField1, {
     preferredCountries: ["tr", "sy", "ae"],
      utilsScript:
        "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
    });
  </script>


<script>
    jQuery(document).ready(function(){
       jQuery('#whatsapp_send').click(function(){
        var value = phoneInput.getNumber();
        value2 = value.substring(1);
        $('input[name="whatsapp"]').val(value2);
          var whatsapp = $('input[name = whatsapp]').val();
          var ID = document.getElementById("ID").value;
          console.log(whatsapp);
          if (value.indexOf('+') == 0) {
           
          $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
             }
         });
          jQuery.ajax({
             url: "/cardedit-ajax/" + ID ,
             method: 'post',
             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
             data: { _token: $('#token').val(),
                        whatsapp: $('input[name = whatsapp]').val(),  },
             success: function(result){
                console.log(result);
             }});
             $('#whatsapp'). modal('hide');
             var x = document.getElementById("snackbar");
            x.className = "show";
            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 2000);
            } else {
            alert("Wrong Number");
    }
          });
       });
</script>

<script>
    jQuery(document).ready(function(){
       jQuery('#website_send').click(function(e){
          e.preventDefault();
          var website = $('input[name = website]').val();
          var ID = document.getElementById("ID").value;
          $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
             }
         });
          jQuery.ajax({
             url: "/cardedit-ajax/" + ID ,
             method: 'post',
             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
             data: { _token: $('#token').val(),
                        website: $('input[name = website]').val(),  },
             success: function(result){
                console.log(result);
             }});
             $('#website').modal('hide');
             var x = document.getElementById("snackbar");
            x.className = "show";
            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 2000);
          });
       });
</script>

<script>
    jQuery(document).ready(function(){
       jQuery('#bank_send').click(function(e){
          e.preventDefault();
          var bank = $('input[name = bank]').val();
          var ID = document.getElementById("ID").value;
          $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
             }
         });
          jQuery.ajax({
             url: "/cardedit-ajax/" + ID ,
             method: 'post',
             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
             data: { _token: $('#token').val(), 
             bank: $('input[name = bank]').val(),},
             success: function(result){
                console.log(result);
             }});
             $('#bank'). modal('hide');var x = document.getElementById("snackbar");
            x.className = "show";
            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 2000);
          });
       });
</script>

<script>
    jQuery(document).ready(function(){
       jQuery('#bank_send').click(function(e){
          e.preventDefault();
          var ID = document.getElementById("ID").value;
          $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
             }
         });
          jQuery.ajax({
             url: "/cardedit-ajax/" + ID ,
             method: 'post',
             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
             data: { _token: $('#token').val(), 
             bank: $('input[name = bank]').val(),
             bankname: $('input[name = bankname]').val(),
             bankiban: $('input[name = bankiban]').val(),},
             success: function(result){
                console.log(result);
             }});
             $('#bank'). modal('hide');var x = document.getElementById("snackbar");
            x.className = "show";
            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 2000);
          });
       });
</script>


<script>
    jQuery(document).ready(function(){
       jQuery('#behance_send').click(function(e){
          e.preventDefault();
          var behance = $('input[name = behance]').val();
          var ID = document.getElementById("ID").value;
          $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
             }
         });
          jQuery.ajax({
             url: "/cardedit-ajax/" + ID ,
             method: 'post',
             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
             data: { _token: $('#token').val(), 
             behance: $('input[name = behance]').val(),},
             success: function(result){
                console.log(result);
             }});
             $('#behance'). modal('hide');var x = document.getElementById("snackbar");
            x.className = "show";
            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 2000);
          });
       });
</script>
<script>
    jQuery(document).ready(function(){
        $('textarea[name=description]').change(function(e){ 
          e.preventDefault();
          var description = $('textarea[name = description]').val();
          var ID = document.getElementById("ID").value;
          $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
             }
         });
          jQuery.ajax({
             url: "/cardedit-ajax/" + ID ,
             method: 'post',
             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
             data: { _token: $('#token').val(), 
             description: $('textarea[name = description]').val(),},
             success: function(result){
                console.log(result);
             }});
             $('#description'). modal('hide');var x = document.getElementById("snackbar");
            x.className = "show";
            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 2000);
          });
       });
</script>
<script>
    jQuery(document).ready(function(){
       jQuery('#discord_send').click(function(e){
          e.preventDefault();
          var discord = $('input[name = discord]').val();
          var ID = document.getElementById("ID").value;
          $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
             }
         });
          jQuery.ajax({
             url: "/cardedit-ajax/" + ID ,
             method: 'post',
             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
             data: { _token: $('#token').val(), 
                discord: $('input[name = discord]').val(),
                discordon: $('input[name = discordon]').val(),},
             success: function(result){
                console.log(result);
             }});
             $('#discord'). modal('hide');var x = document.getElementById("snackbar");
            x.className = "show";
            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 2000);
          });
       });
</script>
<script>
    jQuery(document).ready(function(){
       jQuery('#drive_send').click(function(e){
          e.preventDefault();
          var drive = $('input[name = drive]').val();
          var ID = document.getElementById("ID").value;
          $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
             }
         });
          jQuery.ajax({
             url: "/cardedit-ajax/" + ID ,
             method: 'post',
             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
             data: { _token: $('#token').val(), 
             drive: $('input[name = drive]').val(),},
             success: function(result){
                console.log(result);
             }});
             $('#drive'). modal('hide');var x = document.getElementById("snackbar");
            x.className = "show";
            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 2000);
          });
       });
</script>
<script>
    jQuery(document).ready(function(){
       jQuery('#email_send').click(function(e){
        e.preventDefault();
        $(".error").remove();
        var email = $('input[name = email]').val();;
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
      var validEmail = emailReg.test(email);
      if (!validEmail) {
        $('input[name = email]').after('<span style="color: #ff0000" class="error">Enter a valid email</span>');
      } else {
          var ID = document.getElementById("ID").value;
          $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
             }
         });
          jQuery.ajax({
             url: "/cardedit-ajax/" + ID ,
             method: 'post',
             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
             data: { _token: $('#token').val(), 
             email: $('input[name = email]').val(),},
             success: function(result){
                console.log(result);
             }});
             $('#email'). modal('hide');var x = document.getElementById("snackbar");
            x.className = "show";
            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 2000);}
          });
         });
</script>
<script>
    jQuery(document).ready(function(){
       jQuery('#facebook_send').click(function(e){
          e.preventDefault();
          var facebook = $('input[name = facebook]').val();
          var ID = document.getElementById("ID").value;
          $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
             }
         });
          jQuery.ajax({
             url: "/cardedit-ajax/" + ID ,
             method: 'post',
             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
             data: { _token: $('#token').val(), 
             facebook: $('input[name = facebook]').val(),},
             success: function(result){
                console.log(result);
             }});
             $('#facebook'). modal('hide');var x = document.getElementById("snackbar");
            x.className = "show";
            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 2000);
          });
       });
</script>
<script>
    jQuery(document).ready(function(){
       jQuery('#instagram_send').click(function(e){
          e.preventDefault();
          var instagram = $('input[name = instagram]').val();
          var ID = document.getElementById("ID").value;
          $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
             }
         });
          jQuery.ajax({
             url: "/cardedit-ajax/" + ID ,
             method: 'post',
             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
             data: { _token: $('#token').val(), 
             instagram: $('input[name = instagram]').val(),},
             success: function(result){
                console.log(result);
             }});
             $('#instagram'). modal('hide');var x = document.getElementById("snackbar");
            x.className = "show";
            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 2000);
          });
       });
</script>
<script>
    jQuery(document).ready(function(){
       jQuery('#linkedin_send').click(function(e){
          e.preventDefault();
          var linkedin = $('input[name = linkedin]').val();
          var ID = document.getElementById("ID").value;
          $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
             }
         });
          jQuery.ajax({
             url: "/cardedit-ajax/" + ID ,
             method: 'post',
             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
             data: { _token: $('#token').val(), 
             linkedin: $('input[name = linkedin]').val(),},
             success: function(result){
                console.log(result);
             }});
             $('#linkedin'). modal('hide');var x = document.getElementById("snackbar");
            x.className = "show";
            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 2000);
          });
       });
</script>
<script>
    jQuery(document).ready(function(){
       jQuery('#maps_send').click(function(e){
          e.preventDefault();
          var maps = $('input[name = maps]').val();
          var ID = document.getElementById("ID").value;
          $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
             }
         });
          jQuery.ajax({
             url: "/cardedit-ajax/" + ID ,
             method: 'post',
             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
             data: { _token: $('#token').val(), 
             maps: $('input[name = maps]').val(),},
             success: function(result){
                console.log(result);
             }});
             $('#maps'). modal('hide');var x = document.getElementById("snackbar");
            x.className = "show";
            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 2000);
          });
       });
</script>
<script>
    jQuery(document).ready(function(){
        $('input[name=name]').change(function(e){ 
          e.preventDefault();
          var name = $('input[name = name]').val();
          var ID = document.getElementById("ID").value;
          $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
             }
         });
          jQuery.ajax({
             url: "/cardedit-ajax/" + ID ,
             method: 'post',
             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
             data: { _token: $('#token').val(), 
             name: $('input[name = name]').val(),},
             success: function(result){
                console.log(result);
             }});
             $('#name'). modal('hide');var x = document.getElementById("snackbar");
            x.className = "show";
            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 2000);
          });
       });
</script>
<script>
    jQuery(document).ready(function(){
       jQuery('#papara_send').click(function(e){
          e.preventDefault();
          var papara = $('input[name = papara]').val();
          var ID = document.getElementById("ID").value;
          $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
             }
         });
          jQuery.ajax({
             url: "/cardedit-ajax/" + ID ,
             method: 'post',
             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
             data: { _token: $('#token').val(), 
             papara: $('input[name = papara]').val(),},
             success: function(result){
                console.log(result);
             }});
             $('#papara'). modal('hide');var x = document.getElementById("snackbar");
            x.className = "show";
            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 2000);
          });
       });
</script>
<script>
    jQuery(document).ready(function(){
       jQuery('#paypal_send').click(function(e){
          e.preventDefault();
          var paypal = $('input[name = paypal]').val();
          var ID = document.getElementById("ID").value;
          $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
             }
         });
          jQuery.ajax({
             url: "/cardedit-ajax/" + ID ,
             method: 'post',
             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
             data: { _token: $('#token').val(), 
             paypal: $('input[name = paypal]').val(),},
             success: function(result){
                console.log(result);
             }});
             $('#paypal'). modal('hide');var x = document.getElementById("snackbar");
            x.className = "show";
            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 2000);
          });
       });
</script>
<script>
    jQuery(document).ready(function(){
       jQuery('#reddit_send').click(function(e){
          e.preventDefault();
          var reddit = $('input[name = reddit]').val();
          var ID = document.getElementById("ID").value;
          $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
             }
         });
          jQuery.ajax({
             url: "/cardedit-ajax/" + ID ,
             method: 'post',
             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
             data: { _token: $('#token').val(), 
             reddit: $('input[name = reddit]').val(),},
             success: function(result){
                console.log(result);
             }});
             $('#reddit'). modal('hide');var x = document.getElementById("snackbar");
            x.className = "show";
            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 2000);
          });
       });
</script>
<script>
    jQuery(document).ready(function(){
       jQuery('#skype_send').click(function(e){
          e.preventDefault();
          var skype = $('input[name = skype]').val();
          var ID = document.getElementById("ID").value;
          $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
             }
         });
          jQuery.ajax({
             url: "/cardedit-ajax/" + ID ,
             method: 'post',
             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
             data: { _token: $('#token').val(), 
             skype: $('input[name = skype]').val(),},
             success: function(result){
                console.log(result);
             }});
             $('#skype'). modal('hide');var x = document.getElementById("snackbar");
            x.className = "show";
            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 2000);
          });
       });
</script>
<script>
    jQuery(document).ready(function(){
       jQuery('#snapchat_send').click(function(e){
          e.preventDefault();
          var snapchat = $('input[name = snapchat]').val();
          var ID = document.getElementById("ID").value;
          $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
             }
         });
          jQuery.ajax({
             url: "/cardedit-ajax/" + ID ,
             method: 'post',
             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
             data: { _token: $('#token').val(), 
             snapchat: $('input[name = snapchat]').val(),},
             success: function(result){
                console.log(result);
             }});
             $('#snapchat'). modal('hide');var x = document.getElementById("snackbar");
            x.className = "show";
            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 2000);
          });
       });
</script>
<script>
    jQuery(document).ready(function(){
       jQuery('#spotify_send').click(function(e){
          e.preventDefault();
          var spotify = $('input[name = spotify]').val();
          var ID = document.getElementById("ID").value;
          $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
             }
         });
          jQuery.ajax({
             url: "/cardedit-ajax/" + ID ,
             method: 'post',
             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
             data: { _token: $('#token').val(), 
             spotify: $('input[name = spotify]').val(),},
             success: function(result){
                console.log(result);
             }});
             $('#spotify'). modal('hide');var x = document.getElementById("snackbar");
            x.className = "show";
            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 2000);
          });
       });
</script>
<script>
    jQuery(document).ready(function(){
       jQuery('#steam_send').click(function(e){
          e.preventDefault();
          var steam = $('input[name = steam]').val();
          var ID = document.getElementById("ID").value;
          $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
             }
         });
          jQuery.ajax({
             url: "/cardedit-ajax/" + ID ,
             method: 'post',
             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
             data: { _token: $('#token').val(), 
             steam: $('input[name = steam]').val(),},
             success: function(result){
                console.log(result);
             }});
             $('#steam'). modal('hide');var x = document.getElementById("snackbar");
            x.className = "show";
            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 2000);
          });
       });
</script>
<script>
    jQuery(document).ready(function(){
       jQuery('#telegram_send').click(function(e){
          e.preventDefault();
          var telegram = $('input[name = telegram]').val();
          var ID = document.getElementById("ID").value;
          $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
             }
         });
          jQuery.ajax({
             url: "/cardedit-ajax/" + ID ,
             method: 'post',
             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
             data: { _token: $('#token').val(), 
             telegram: $('input[name = telegram]').val(),},
             success: function(result){
                console.log(result);
             }});
             $('#telegramm'). modal('hide');var x = document.getElementById("snackbar");
            x.className = "show";
            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 2000);
          });
       });
</script>
<script>
    jQuery(document).ready(function(){
       jQuery('#telephone_send').click(function(){
        var value = phoneInput1.getNumber();
        $('input[name="telephone"]').val(value);
          var telephone = $('input[name = telephone]').val();
          var ID = document.getElementById("ID").value;
          if (value.indexOf('+') == 0) {
          $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
             }
         });
          jQuery.ajax({
             url: "/cardedit-ajax/" + ID ,
             method: 'post',
             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
             data: { _token: $('#token').val(), 
             telephone: $('input[name = telephone]').val(),},
             success: function(result){
                console.log(result);
             }});
             $('#telephonemodal'). modal('hide');var x = document.getElementById("snackbar");
            x.className = "show";
            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 2000);
            } else {
    alert("Wrong Number");
    }
          });
       });
</script>
<script>
    jQuery(document).ready(function(){
       jQuery('#tiktok_send').click(function(e){
          e.preventDefault();
          var tiktok = $('input[name = tiktok]').val();
          var ID = document.getElementById("ID").value;
          $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
             }
         });
          jQuery.ajax({
             url: "/cardedit-ajax/" + ID ,
             method: 'post',
             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
             data: { _token: $('#token').val(), 
             tiktok: $('input[name = tiktok]').val(),},
             success: function(result){
                console.log(result);
             }});
             $('#tiktok'). modal('hide');var x = document.getElementById("snackbar");
            x.className = "show";
            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 2000);
          });
       });
</script>
<script>
    jQuery(document).ready(function(){
       jQuery('#twitch_send').click(function(e){
          e.preventDefault();
          var twitch = $('input[name = twitch]').val();
          var ID = document.getElementById("ID").value;
          $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
             }
         });
          jQuery.ajax({
             url: "/cardedit-ajax/" + ID ,
             method: 'post',
             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
             data: { _token: $('#token').val(), 
             twitch: $('input[name = twitch]').val(),},
             success: function(result){
                console.log(result);
             }});
             $('#twitchh'). modal('hide');var x = document.getElementById("snackbar");
            x.className = "show";
            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 2000);
          });
       });
</script>
<script>
    jQuery(document).ready(function(){
       jQuery('#twitter_send').click(function(e){
          e.preventDefault();
          var twitter = $('input[name = twitter]').val();
          var ID = document.getElementById("ID").value;
          $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
             }
         });
          jQuery.ajax({
             url: "/cardedit-ajax/" + ID ,
             method: 'post',
             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
             data: { _token: $('#token').val(), 
             twitter: $('input[name = twitter]').val(),},
             success: function(result){
                console.log(result);
             }});
             $('#twitter'). modal('hide');var x = document.getElementById("snackbar");
            x.className = "show";
            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 2000);
          });
       });
</script>
<script>
    jQuery(document).ready(function(){
       jQuery('#youtube_send').click(function(e){
          e.preventDefault();
          var youtube = $('input[name = youtube]').val();
          var ID = document.getElementById("ID").value;
          $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
             }
         });
          jQuery.ajax({
             url: "/cardedit-ajax/" + ID ,
             method: 'post',
             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
             data: { _token: $('#token').val(), 
             youtube: $('input[name = youtube]').val(),},
             success: function(result){
                console.log(result);
             }});
             $('#youtube'). modal('hide');var x = document.getElementById("snackbar");
            x.className = "show";
            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 2000);
          });
       });
</script>


