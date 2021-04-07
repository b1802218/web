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
    $slogin_id = isset($_SESSION['login_id']) ? $_SESSION['login_id'] : "";

    //ログインパスワード
    $sLoginPass = isset($_SESSION['login_pass']) ? $_SESSION['login_pass'] : "";

     //商品ID
     $nItemId = isset($_POST['item_id']) ? $_POST['item_id'] : "";
     $gItemId = isset($_GET['item_id']) ? $_GET['item_id'] : "";
    
     //商品名
     $nItemName = isset($_POST['item_name']) ? $_POST['item_name'] : "";
     
     //詳細
     $nItemexp = isset($_POST['item_exp']) ? $_POST['item_exp'] : "";
 
     //金額
     $nItemPrice = isset($_POST['item_price']) ? $_POST['item_price'] : "";
 
     //商品数量
     $nItemNum = isset($_POST['item_stock']) ? $_POST['item_stock'] : "";
 
     //カテゴリID
     $nCategoryId = isset($_POST['category_id']) ? $_POST['category_id'] : "";

     $nCategoryname = isset($_POST['category_name']) ? $_POST['category_name'] : "";

     //販売停止
     $nflag = isset($_POST['flag']) ? $_POST['flag'] : "";

     //処理ステップ
    $nStepFlg = isset($_POST['step']) ? $_POST['step'] : "";

    //処理ステップ1
    $nStepFlg1 = isset($_POST['step1']) ? $_POST['step1'] : "";

     //（変更用）商品名
    $hKeyword = isset($_POST['hkeyword']) ? $_POST['hkeyword'] : "";

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
if($nStepFlg == ""){
    //商品一覧を取得
    $arrItem = itemselect($gItemId);

    $nItemName = $arrItem[0]['item_name'];

    $nItemexp = $arrItem[0]['item_exp'];

    $nItemPrice = $arrItem[0]['item_price'];

    $nItemNum = $arrItem[0]['item_stock'];

    $nCategoryId = $arrItem[0]['category_id'];

    $nflag = $arrItem[0]['flag'];

    //カテゴリを取得
    $arrCategory = getCategory();
}
//**************************************************
// STEP1（確認画面）
//**************************************************
if($nStepFlg == 1 || $nStepFlg == 2){

    // 商品名チェック
    if(mb_strlen($nItemName, "UTF-8") > 50) {
        $arrErr['item_name'] = "商品名は50文字以内で入力してください";
    }
    
    // 詳細チェック
    if(mb_strlen($nItemexp, "UTF-8") > 100) {
        $arrErr['item_exp'] = "詳細は100文字以内で入力してください";
    }


    // 金額チェック
    if(mb_strlen($nItemPrice, "UTF-8") > 5000) {
        $arrErr['item_price'] = "金額は5000円以内で入力してください";
    }


    // 商品数量チェック
    if(mb_strlen($nItemNum, "UTF-8") > 50) {
        $arrErr['item_stock'] = "数量は50個以内で入力してください";
    }


    // カテゴリチェック
    if(mb_strlen($nCategoryId, "UTF-8") > 50) {
        $arrErr['category_id'] = "カテゴリは50文字以内で入力してください";
    }
    

    //入力エラーがある場合は最初のステップに戻す
    if(count($arrErr) > 0){
        $nStepFlg = "";
    }
}

//**************************************************
// 編集
//**************************************************
if($nStepFlg == 2){
        //メッセージ用の変数
        $resultMsg = "";

        //変更（商品IDがあるとき）
        if($nItemId != ""){
            //カートへ追加処理
            $bRet = upDataItem($nItemId, $nItemName ,$nItemexp,$nItemPrice,$nItemNum,$nCategoryId,$nflag);
    
        //DB登録エラーがある場合は最初のステップに戻す
        if($bRet == false){
            $nStepFlg = "";
        }
    }
   
}
//**************************************************
// HTMLを出力
//**************************************************
if($nStepFlg == ""){
    require_once('../view/adminext.html');
} else if ($nStepFlg == 1) {
    require_once('../view/adminextCheck.html');
} else if ($nStepFlg == 2) {
    require_once('../view/adminextOK.html');
} 
?>