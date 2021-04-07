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

    //ユーザーID
    $userId = isset($_POST['user_id']) ? $_POST['user_id'] : "";

    //商品ID
    $nItemId = isset($_POST['item_id']) ? $_POST['item_id'] : "";

    //商品数量
    $nItemNum = isset($_POST['item_num']) ? $_POST['item_num'] : "";

    //（検索用）注文番号
    $nKeyword = isset($_POST['keyword']) ? $_POST['keyword'] : "";

    //（検索用）会員名
    $nKeyword2 = isset($_POST['keyword2']) ? $_POST['keyword2'] : "";

//**************************************************
// ログインチェック処理
//**************************************************
    //ログインチェックを取得
    $loginOk = loginCheck($slogin_id, $sLoginPass);



//**************************************************
// 数量変更処理
//**************************************************

//**************************************************
// 検索処理
//**************************************************
    //カート内一覧を取得
    $arrdate = Cartselect($nKeyword,$nKeyword2);


    
//**************************************************
// HTMLを出力
//**************************************************
    //画面へ表示
    require_once('../view/adminorder.html');

?>