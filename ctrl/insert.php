<?php
//**************************************************
// 初期処理
//**************************************************
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


//**************************************************
// STEP1（確認画面）
//**************************************************
    if($nStepFlg == 1 || $nStepFlg == 2){

        // 苗字チェック
        if($sLastName == ""){
            $arrErr['last_name'] = "苗字を入力してください";
        }
        else if(mb_strlen($sLastName, "UTF-8") > 10) {
            $arrErr['last_name'] = "苗字は10文字以内で入力してください";
        }

        // 名前チェック
        if($sFirstName == ""){
            $arrErr['first_name'] = "名前を入力してください";
        }
        else if(mb_strlen($sFirstName, "UTF-8") > 10) {
            $arrErr['first_name'] = "名前は10文字以内で入力してください";
        }
		
		// 郵便番号チェック
        if($sPcode == ""){
            $arrErr['Pcode'] = "郵便番号を入力してください";
        }
        else if(is_numeric($sPcode) == false ||mb_strlen($sPcode, "UTF-8") > 7) {
            $arrErr['Pcode'] = "郵便番号はハイフンを入れずに入力してください";
        }

        // 住所チェック
        if($sSaddress == ""){
            $arrErr['Saddress'] = "住所を入力してください";
        }
        else if(mb_strlen($sSaddress, "UTF-8") > 50) {
            $arrErr['Saddress'] = "住所は50文字以内で入力してください";
        }

        // 電話番号チェック
        if($sPnumber == ""){
            $arrErr['Pnumber'] = "電話番号を入力してください";
        }
        else if(is_numeric($sPnumber) == false || mb_strlen($sPnumber, "UTF-8") > 11){
            $arrErr['Pnumber'] = "電話番号はハイフンを入れないで入力してください";
        }

        // メールアドレスチェック
        if($semail == ""){
            $arrErr['email'] = "メールアドレスを入力してください";
        }
        else if(!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/",$semail)) {
            $arrErr['email'] = "メールアドレスは半角英数字記号で入力してください";
        }
		
		// パスチェック
        if($sloginPass == ""){
            $arrErr['login_pass'] = "パスワードを入力してください";
        }
        else if(!preg_match("/^[a-zA-Z0-9_-]+$/",$sloginPass)) {
            $arrErr['login_pass'] = "パスワードは半角英数字記号(_-)のみで入力してください";
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
        $bRet = insertMember($sFirstName, $sLastName,$sPcode,$sSaddress,$sPnumber,$semail,$sloginPass);

        //DB登録エラーがある場合は最初のステップに戻す
        if($bRet == false){
            $nStepFlg = "";
        }
    }

//**************************************************
// HTML表示
//**************************************************
    if($nStepFlg == ""){
        require_once('../view/insert.html');
    } else if ($nStepFlg == 1) {
        require_once('../view/insertCheck.html');
    } else if ($nStepFlg == 2) {
        require_once('../view/insertOK.html');
    }
?>