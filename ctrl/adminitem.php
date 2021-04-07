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

    //商品ID
    $nItemId = isset($_POST['item_id']) ? $_POST['item_id'] : "";

    //商品数量
    $nItemNum = isset($_POST['item_num']) ? $_POST['item_num'] : "";

    //（検索用）商品名
    $sKeyword = isset($_POST['keyword']) ? $_POST['keyword'] : "";

    //（検索用）カテゴリID
    $nCateId = isset($_POST['category_id']) ? $_POST['category_id'] : "";

    //（検索用）金額
    $nKeyword2 = isset($_POST['keyword2']) ? $_POST['keyword2'] : "";

    //（検索用）金額
    $nKeyword4 = isset($_POST['keyword4']) ? $_POST['keyword4'] : "";

    //（検索用）販売有無
    $nKeyword3 = isset($_POST['keyword3']) ? $_POST['keyword3'] : "";

    //処理ステップ
    $nStepFlg = isset($_POST['step']) ? $_POST['step'] : "";

    
//**************************************************
// ログインチェック処理
//**************************************************
    //ログインチェックを取得
    $loginOk = loginCheck($slogin_id, $sLoginPass);

//**************************************************
// 検索処理
//**************************************************
    //商品一覧を取得
    $arrItem = selectItem($sKeyword, $nCateId, $nKeyword2,$nKeyword3,$nKeyword4);

    //カテゴリを取得
    $arrCategory = getCategory();


//**************************************************
// HTMLを出力
//**************************************************
    //画面へ表示
    require_once('../view/adminitem.html');
?>