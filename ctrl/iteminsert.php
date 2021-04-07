<?php
//**************************************************
// 初期処理
//**************************************************
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
    //商品ID
    $nItemId = isset($_POST['item_id']) ? $_POST['item_id'] : "";
    
    //商品名
    $nItemName = isset($_POST['item_name']) ? $_POST['item_name'] : "";
    
    //詳細
    $nItemexp = isset($_POST['item_exp']) ? $_POST['item_exp'] : "";

    //金額
    $nItemPrice = isset($_POST['item_price']) ? $_POST['item_price'] : "";

    //商品数量
    $nItemNum = isset($_POST['item_stock']) ? $_POST['item_stock'] : "";

    //カテゴリ名
    $nCategoryId = isset($_POST['category_id']) ? $_POST['category_id'] : "";
	
    //処理ステップ
    $nStepFlg = isset($_POST['step']) ? $_POST['step'] : "";

    //カテゴリを取得
    $arrCategory = getCategory();
//**************************************************
// STEP1（確認画面）
//**************************************************
    if($nStepFlg == 1 || $nStepFlg == 2){

        // 商品名チェック
        if($nItemName == ""){
            $arrErr['item_name'] = "商品名を入力してください";
        }
        else if(mb_strlen($nItemName, "UTF-8") > 50) {
            $arrErr['item_name'] = "商品名は50文字以内で入力してください";
        }
		
		// 詳細チェック
        if($nItemexp == ""){
            $arrErr['item_exp'] = "詳細を入力してください";
        }
        else if(mb_strlen($nItemexp, "UTF-8") > 100) {
            $arrErr['item_exp'] = "詳細は100文字以内で入力してください";
        }

        // 金額チェック
        if($nItemPrice == ""){
            $arrErr['item_price'] = "金額を入力してください";
        }
        else if(mb_strlen($nItemPrice, "UTF-8") > 5000) {
            $arrErr['item_price'] = "金額は5000円以内で入力してください";
        }

        // 商品数量チェック
        if($nItemNum == ""){
            $arrErr['item_stock'] = "数量を入力してください";
        }
        else if(mb_strlen($nItemNum, "UTF-8") > 50) {
            $arrErr['item_stock'] = "数量は50個以内で入力してください";
        }

        // カテゴリチェック
        if($nCategoryId == ""){
            $arrErr['category_id'] = "カテゴリを入力してください";
        }
        else if(mb_strlen($nCategoryId, "UTF-8") > 50) {
            $arrErr['category_id'] = "カテゴリは50文字以内で入力してください";
        }
		

        //入力エラーがある場合は最初のステップに戻す
        if(count($arrErr) > 0){
            $nStepFlg = "";
        }
    }

//**************************************************
// STEP2（完了画面）
//**************************************************
    if($nStepFlg == 2 && count($arrErr) == 0){

        //データ登録
        $bRet = insertItem($nItemId, $nItemName ,$nItemexp,$nItemPrice,$nItemNum,$nCategoryId);

        //DB登録エラーがある場合は最初のステップに戻す
        if($bRet == false){
            $nStepFlg = "";
        }
    }

//**************************************************
// HTML表示
//**************************************************
    if($nStepFlg == ""){
        require_once('../view/iteminsert.html');
    } else if ($nStepFlg == 1) {
        require_once('../view/iteminsertCheck.html');
    } else if ($nStepFlg == 2) {
        require_once('../view/iteminsertOK.html');
    }
?>