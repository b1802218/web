<?php
//**************************************************
// 初期処理
//**************************************************
    //SESSIONスタート
    session_start();

    //データベース接続関数の定義ファイルを読み込み
    require_once('../model/dbconnect.php');

    //データベース操作関数の定義ファイルを読み込み
    require_once('../model/dbfunction.php');

//**************************************************
// 変数定義
//**************************************************
    //エラー検知用
    $bRet = false;

    //エラーメッセージ用
    $arrErr = array();

//**************************************************
// 変数取得
//**************************************************
    //ログインID
    $semail = isset($_SESSION['email']) ? $_SESSION['email'] : "";

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

    //(検索用)金額
    $nKeyword2 = isset($_POST['keyword2']) ? $_POST['keyword2'] : "";

    //(検索用)金額
    $nKeyword3 = isset($_POST['keyword3']) ? $_POST['keyword3'] : "";

//**************************************************
// ログインチェック処理
//**************************************************
    //ログインチェックを取得
    $loginOk = loginCheck($semail, $sLoginPass);

    //ログインOKならユーザIDとユーザ名を取得
    if($loginOk === true){
        $userId   = getUserId($semail, $sLoginPass);
        $userName = getUserName($semail, $sLoginPass);
    }

//**************************************************
// カートに入れる処理
//**************************************************
    //メッセージ用の変数
    $resultMsg = "";

    //商品追加（商品IDがあって、数量が1つ以上のとき）
    if($nItemId != "" && $nItemNum > 0){
        //カートへ追加処理
        $result = addCart($nItemId, $nItemNum, $userId);

        //メッセージ
        if($result === true){
            $resultMsg = "カートに".$nItemNum."件追加しました。";
        }
        else {
            $resultMsg = "カートに追加できませんでした。";
        }
    }

//**************************************************
// 検索処理
//**************************************************
    //商品一覧を取得
    $arrItem = selectItem($sKeyword, $nCateId, $nKeyword2,$nKeyword3);

    //カテゴリを取得
    $arrCategory = getCategory();


//**************************************************
// カート内の件数を取得
//**************************************************
    //ログインOKなら取得
    if($loginOk === true){
        $cartCnt = countCart($userId);
    }
    else {
        $cartCnt = "";
    }


//**************************************************
// HTMLを出力
//**************************************************
    //画面へ表示
    require_once('../view/index1.html');

?>