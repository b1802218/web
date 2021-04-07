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

    //処理ステップ
    $nStepFlg = isset($_POST['step']) ? $_POST['step'] : "";

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
// 検索処理
//**************************************************
    //商品一覧を取得
    $arrItem = itemselect($nItemId);

    //カテゴリを取得
    $arrCategory = getCategory();

//**************************************************
// 削除処理
//**************************************************
if($nStepFlg == 1){

    //データ登録
    $result = clearItem($nItemId);

        //メッセージ
        if($result === true){
            $resultMsg = "数量を変更しました。";
        }
        else {
            $resultMsg = "数量を変更できませんでした。";
        }
}

//**************************************************
// HTMLを出力
//**************************************************
if($nStepFlg == ""){
    require_once('../view/admindelete.html');
} else if ($nStepFlg == 1) {
    require_once('../view/deleteOk.html');
}
?>