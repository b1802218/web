<?php
//**************************************************
// 初期処理
//**************************************************
    //SESSIONスタート
    session_start();

    //データベース接続関数の定義ファイルを読み込み
    require_once('../model/dbconnect2.php');

    //データベース操作関数の定義ファイルを読み込み
    require_once('../model/dbfunction2.php');

//**************************************************
// 変数取得
//**************************************************
    //ログインID
    $slogin_id = isset($_SESSION['login_id']) ? $_SESSION['login_id'] : "";

    //ログインパスワード
    $sLoginPass = isset($_SESSION['login_pass']) ? $_SESSION['login_pass'] : "";
    
     //ID
     $sId = isset($_POST['id']) ? $_POST['id'] : "";

    //苗字
    $sLastName = isset($_POST['last_name']) ? $_POST['last_name'] : "";

    //名前
    $sFirstName = isset($_POST['first_name']) ? $_POST['first_name'] : "";
    
    //郵便番号
    $sPcode = isset($_POST['Pcode']) ? $_POST['Pcode'] : "";
        
    //住所
    $sSaddress = isset($_POST['Saddress']) ? $_POST['Saddress'] : "";
        
    //電話番号
    $sPnumber = isset($_POST['Pnumber']) ? $_POST['Pnumber'] : "";
        
    //メールアドレス
    $semail = isset($_POST['email']) ? $_POST['email'] : "";
    
    //pass
    $sloginPass = isset($_POST['login_pass']) ? $_POST['login_pass'] : "";
        
    //処理ステップ
    $nStepFlg = isset($_POST['step']) ? $_POST['step'] : "";

    //（検索用）会員名
    $skKeyword = isset($_POST['kkeyword']) ? $_POST['kkeyword'] : "";

    //（検索用）住所
    $skKeyword2 = isset($_POST['kkeyword2']) ? $_POST['kkeyword2'] : "";

    //(検索用)　メールアドレス
    $skKeyword3 = isset($_POST['kkeyword3']) ? $_POST['kkeyword3'] : "";

//**************************************************
// ログインチェック処理
//**************************************************
    //ログインチェックを取得
    $loginOk = loginCheck($slogin_id, $sLoginPass);

    //ログインOKならユーザIDとユーザ名を取得
    if($loginOk === true){
        $userName = getUserName($slogin_id, $sLoginPass);
    }

//**************************************************
// 検索処理
//**************************************************

    //会員一覧を取得
    $arrmember = selectmember($skKeyword,$skKeyword2,$skKeyword3);

//**************************************************
// HTMLを出力
//**************************************************
    //画面へ表示
    require_once('../view/admincustomer.html');
?>