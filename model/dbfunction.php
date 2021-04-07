<?php
####################################################################################
### ユーザ関連
####################################################################################
/****************************************
 * ログインチェック
 * $sLoginId　：ログインID（未指定は空白）
 * $sLoginPass：ログインパスワード（未指定は空白）
 ****************************************/
function loginCheck($semail = "", $sLoginPass = ""){

    //初期化
    $arrUser = array();

    //データベース接続関数の呼び出し
    $pdo = db_connect();

    try {
        //変数の準備
        $sSql  = "";

        //データ検索のSQLを作成
        $sSql .= "SELECT ";
        $sSql .= "   * ";
        $sSql .= "FROM ";
        $sSql .= "   customer ";
        $sSql .= "WHERE ";
        $sSql .= "  email = :email AND ";
        $sSql .= "  login_pass = :login_pass ";


        //ステートメントハンドラを作成
        $stmh = $pdo->prepare($sSql);
        $stmh->bindValue(':email',   $semail,   PDO::PARAM_STR);
        $stmh->bindValue(':login_pass', $sLoginPass, PDO::PARAM_STR);

        //SQL文の実行
        $stmh->execute();

        //実行結果を取得
        $arrUser = $stmh->fetch(PDO::FETCH_ASSOC);

        //ログイン情報の有無を判定
        if($arrUser !== false){
            return true;
        }

    } catch (PDOException $Exception) {

        //例外が発生したらエラーを出力
        die('実行エラー（' . __FUNCTION__."）：".$Exception->getMessage()."<br />");

    }

    return false;

}

/****************************************
 * ログインユーザのユーザIDを取得
 * $sLoginId　：ログインID
 * $sLoginPass：ログインパスワード
 ****************************************/
function getUserId($semail = "", $sLoginPass = ""){

    //初期化
    $arrUser = array();
    $sUserId = "";

    //データベース接続関数の呼び出し
    $pdo = db_connect();

    try {
        //変数の準備
        $sSql  = "";

        //データ検索のSQLを作成
        $sSql .= "SELECT ";
        $sSql .= "   id ";
        $sSql .= "FROM ";
        $sSql .= "   customer ";
        $sSql .= "WHERE ";
        $sSql .= "  email = :email AND ";
        $sSql .= "  login_pass = :login_pass ";


        //ステートメントハンドラを作成
        $stmh = $pdo->prepare($sSql);
        $stmh->bindValue(':email',   $semail,   PDO::PARAM_STR);
        $stmh->bindValue(':login_pass', $sLoginPass, PDO::PARAM_STR);

        //SQL文の実行
        $stmh->execute();

        //実行結果を取得
        $arrUser = $stmh->fetch(PDO::FETCH_ASSOC);

        //ユーザID取得
        $sUserId = $arrUser["id"];


    } catch (PDOException $Exception) {

        //例外が発生したらエラーを出力
        die('実行エラー（' . __FUNCTION__."）：".$Exception->getMessage()."<br />");

    }

    return $sUserId;

}

/****************************************
 * ログインユーザ名取得
 * $sLoginId　：ログインID
 * $sLoginPass：ログインパスワード
 ****************************************/
function getUserName($semail = "", $sLoginPass = ""){

    //初期化
    $arrUser = array();
    $sUserName = "";

    //データベース接続関数の呼び出し
    $pdo = db_connect();

    try {
        //変数の準備
        $sSql  = "";

        //データ検索のSQLを作成
        $sSql .= "SELECT ";
        $sSql .= "   last_name, ";
        $sSql .= "   first_name ";
        $sSql .= "FROM ";
        $sSql .= "   customer ";
        $sSql .= "WHERE ";
        $sSql .= "  email = :email AND ";
        $sSql .= "  login_pass = :login_pass ";


        //ステートメントハンドラを作成
        $stmh = $pdo->prepare($sSql);
        $stmh->bindValue(':email',   $semail,   PDO::PARAM_STR);
        $stmh->bindValue(':login_pass', $sLoginPass, PDO::PARAM_STR);

        //SQL文の実行
        $stmh->execute();

        //実行結果を取得
        $arrUser = $stmh->fetch(PDO::FETCH_ASSOC);

        //ユーザ名取得
        $sUserName = $arrUser["last_name"] . " " . $arrUser["first_name"];


    } catch (PDOException $Exception) {

        //例外が発生したらエラーを出力
        die('実行エラー（' . __FUNCTION__."）：".$Exception->getMessage()."<br />");

    }

    return $sUserName;

}

/****************************************
 * メンバー登録
 * $sFirstName：名前
 * $sLastName：苗字
 ****************************************/
function insertMember($sFirstName, $sLastName,$sPcode,$sSaddress,$sPnumber,$semail,$sloginPass){

	//データベース接続関数の呼び出し
	$pdo = db_connect();

	try {
		//データ検索の条件
		$sSql = "INSERT INTO customer (last_name, first_name,Pcode,Saddress,Pnumber,email,login_pass)
				VALUES (:last_name, :first_name, :Pcode, :Saddress, :Pnumber, :email, :login_pass)";
		
		//ステートメントハンドラを作成
		$stmh = $pdo->prepare($sSql);
		
		//バインドの実行
		$stmh->bindValue(':last_name',  $sLastName,  PDO::PARAM_STR);
        $stmh->bindValue(':first_name', $sFirstName, PDO::PARAM_STR);
        $stmh->bindValue(':Pcode', $sPcode, PDO::PARAM_STR);
        $stmh->bindValue(':Saddress', $sSaddress, PDO::PARAM_STR);
        $stmh->bindValue(':Pnumber', $sPnumber, PDO::PARAM_STR);
        $stmh->bindValue(':email', $semail, PDO::PARAM_STR);
		$stmh->bindValue(':login_pass', $sloginPass, PDO::PARAM_STR);
		//SQL文の実行
		$stmh->execute();

		//登録成功を返却
		return true;

	
	} catch (PDOException $Exception) {
	
		//例外が発生したらエラーを出力
		die('実行エラー :' . $Exception->getMessage()."<br />");
	
		//登録失敗を返却
		return false;

	}

}  
####################################################################################
### 商品関連
####################################################################################
/****************************************
 * 商品一覧取得
 ****************************************/
function selectItem($keyword, $categoryId, $keyword2, $keyword3){

    //初期化
    $arrItem = array();
    $sWhere = "";

    //データベース接続関数の呼び出し
    $pdo = db_connect();

    try {
        //データ検索のSQLを作成
        $sSql  = "";
        $sSql .= "SELECT ";
        $sSql .= "   A.item_id, ";
        $sSql .= "   A.item_name, ";
        $sSql .= "   A.item_exp, ";
        $sSql .= "   A.item_price, ";
        $sSql .= "   A.item_stock, ";
        $sSql .= "   A.category_id, ";
        $sSql .= "   B.category_name ";
        $sSql .= "FROM ";
        $sSql .= "   item A ";
        $sSql .= "LEFT JOIN ";
        $sSql .= "   category B ";
        $sSql .= "ON ";
        $sSql .= "   A.category_id = B.category_id ";

        //データ検索の条件
        if($keyword != ""){
            //キーワード
            $sWhere .= ($sWhere == "") ? "WHERE " : "AND ";
            $sWhere .= "A.item_name LIKE :item_name ";
        }
        if($categoryId != ""){
            //カテゴリID
            $sWhere .= ($sWhere == "") ? "WHERE " : "AND ";
            $sWhere .= "A.category_id = :category_id ";
        }
        if($keyword2 != ""){
            //キーワード
            $sWhere .= ($sWhere == "") ? "WHERE " : "AND ";
            $sWhere .= "A.item_price >= :item_price1 ";
        }
        if($keyword3 != ""){
            //キーワード
            $sWhere .= ($sWhere == "") ? "WHERE " : "AND ";
            $sWhere .= "A.item_price <= :item_price2 ";
        }

        //ステートメントハンドラを作成
        $stmh = $pdo->prepare($sSql.$sWhere);

        //バインドの実行
        if($keyword != ""){
            //キーワード
            $stmh->bindValue(':item_name',  "%".$keyword."%", PDO::PARAM_STR);
        }
        if($categoryId != ""){
            //カテゴリID
            $stmh->bindValue(':category_id',  $categoryId, PDO::PARAM_INT);
        }
        if($keyword2 != ""){
            //カテゴリID
            $stmh->bindValue(':item_price1',  $keyword2, PDO::PARAM_INT);
        }
        if($keyword3 != ""){
            //カテゴリID
            $stmh->bindValue(':item_price2',  $keyword3, PDO::PARAM_INT);
        }

        //SQL文の実行
        $stmh->execute();

        //実行結果を取得
        $arrItem = $stmh->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $Exception) {

        //例外が発生したらエラーを出力
        die('実行エラー（' . __FUNCTION__."）：".$Exception->getMessage()."<br />");

    }

    return $arrItem;

}



/****************************************
 * 詳細
 ****************************************/

function itemselect($nItemId){

    //初期化
    $arrItem = array();

    //データベース接続関数の呼び出し
    $pdo = db_connect();

    try {
        //データ検索のSQLを作成
        $sSql  = "";
        $sSql .= "SELECT ";
        $sSql .= "   A.item_id, ";
        $sSql .= "   A.item_name, ";
        $sSql .= "   A.item_exp, ";
        $sSql .= "   A.item_price, ";
        $sSql .= "   A.item_stock, ";
        $sSql .= "   A.category_id, ";
        $sSql .= "   B.category_name, ";
        $sSql .= "   A.flag ";
        $sSql .= "FROM ";
        $sSql .= "   item A ";
        $sSql .= "LEFT JOIN ";
        $sSql .= "   category B ";
        $sSql .= "ON ";
        $sSql .= "   A.category_id = B.category_id ";
        $sSql .= "WHERE ";
        $sSql .= "   A.item_id = :item_id ";

        //ステートメントハンドラを作成
        $stmh = $pdo->prepare($sSql);
        $stmh->bindValue(':item_id', $nItemId, PDO::PARAM_INT);
        $stmh->execute();
        $arrItem = $stmh->fetch(PDO::FETCH_ASSOC);

        //SQL文の実行
        $stmh->execute();

        //実行結果を取得
        $arrItem = $stmh->fetchAll(PDO::FETCH_ASSOC);
        

    } catch (PDOException $Exception) {

        //例外が発生したらエラーを出力
        die('実行エラー（' . __FUNCTION__."）：".$Exception->getMessage()."<br />");

    }

    return $arrItem;

}

/****************************************
 * カテゴリ取得
 ****************************************/
function getCategory(){

    //初期化
    $arrCategory = array();

    //データベース接続関数の呼び出し
    $pdo = db_connect();

    try {
        //変数の準備
        $sSql  = "";

        //データ検索のSQLを作成
        $sSql .= "SELECT ";
        $sSql .= "   * ";
        $sSql .= "FROM ";
        $sSql .= "   category ";


        //ステートメントハンドラを作成
        $stmh = $pdo->prepare($sSql);

        //SQL文の実行
        $stmh->execute();

        //実行結果を取得
        $arrCategory = $stmh->fetchAll(PDO::FETCH_ASSOC);


    } catch (PDOException $Exception) {

        //例外が発生したらエラーを出力
        die('実行エラー（' . __FUNCTION__."）：".$Exception->getMessage()."<br />");

    }

    return $arrCategory;

}



####################################################################################
### カート関連
####################################################################################
/****************************************
 * カート一覧取得
 * $nUserId：ユーザID
 ****************************************/
function selectCart($nUserId = ""){

    //ユーザID未指定の場合は×
    if($nUserId == ""){
        return false;
    }

    //初期化
    $arrCart = array();

    //データベース接続関数の呼び出し
    $pdo = db_connect();

    try {
        //データ検索のSQLを作成
        $sSql  = "";
        $sSql .= "SELECT ";
        $sSql .= "   A.item_id, ";
        $sSql .= "   A.item_num, ";
        $sSql .= "   B.item_name, ";
        $sSql .= "   B.item_exp, ";
        $sSql .= "   B.item_price, ";
        $sSql .= "   B.item_stock ";
        $sSql .= "FROM ";
        $sSql .= "   cart A ";
        $sSql .= "LEFT JOIN ";
        $sSql .= "   item B ";
        $sSql .= "ON ";
        $sSql .= "   A.item_id = B.item_id ";
        $sSql .= "WHERE ";
        $sSql .= "  A.user_id = :user_id ";
        $sSql .= "ORDER BY ";
        $sSql .= "  A.item_id ";

        //SQLを実行～取得
        $stmh = $pdo->prepare($sSql);
        $stmh->bindValue(':user_id', $nUserId, PDO::PARAM_INT);
        $stmh->execute();
        $arrCart = $stmh->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $Exception) {

        //例外が発生したらエラーを出力
        die('実行エラー（' . __FUNCTION__."）：".$Exception->getMessage()."<br />");

    }

    return $arrCart;

}

/****************************************
 * カート内件数を取得
 * $nUserId：ユーザID
 ****************************************/
function countCart($nUserId = ""){

    //ユーザID未指定の場合は×
    if($nUserId == ""){
        return 0;
    }

    //初期化
    $nCartCnt = 0;

    //データベース接続関数の呼び出し
    $pdo = db_connect();

    try {
        //データ検索のSQLを作成
        $sSql  = "";
        $sSql .= "SELECT ";
        $sSql .= "   COUNT(*) AS CNT ";
        $sSql .= "FROM ";
        $sSql .= "   cart ";
        $sSql .= "WHERE ";
        $sSql .= "  user_id = :user_id ";

        //SQLを実行～取得
        $stmh = $pdo->prepare($sSql);
        $stmh->bindValue(':user_id', $nUserId, PDO::PARAM_INT);
        $stmh->execute();
        $arrCart = $stmh->fetch(PDO::FETCH_ASSOC);

        //件数を取得
        $nCartCnt = isset($arrCart['CNT']) ? $arrCart['CNT'] : 0;

    } catch (PDOException $Exception) {

        //例外が発生したらエラーを出力
        die('実行エラー（' . __FUNCTION__."）：".$Exception->getMessage()."<br />");

    }

    return $nCartCnt;

}

/****************************************
 * カートへ入れる
 * $nItemId ：商品ID
 * $nItemNum：商品数量
 * $nUserId ：ユーザID
 ****************************************/
function addCart($nItemId, $nItemNum, $nUserId){

    //初期化
    $result = false;

    //データベース接続関数の呼び出し
    $pdo = db_connect();

    try {
        //既にデータがあるかどうかを確認するSQL
        $sSql  = "";
        $sSql .= "SELECT ";
        $sSql .= "   * ";
        $sSql .= "FROM ";
        $sSql .= "   cart ";
        $sSql .= "WHERE ";
        $sSql .= "  item_id = :item_id AND ";
        $sSql .= "  user_id = :user_id ";

        //SQL実行～取得
        $stmh = $pdo->prepare($sSql);
        $stmh->bindValue(':item_id', $nItemId, PDO::PARAM_INT);
        $stmh->bindValue(':user_id', $nUserId, PDO::PARAM_INT);
        $stmh->execute();
        $arrItem = $stmh->fetch(PDO::FETCH_ASSOC);

        //登録されていない場合はINSERT
        if($arrItem === false){
            //INSERT文作成
            $sSql  = "";
            $sSql .= "INSERT INTO cart ";
            $sSql .= "  (user_id, item_id, item_num) ";
            $sSql .= "VALUES ";
            $sSql .= "  (:user_id, :item_id, :item_num)";
        }
        //登録されている場合はUPDATE
        else {
            //UPDATE文作成
            $sSql  = "";
            $sSql .= "UPDATE cart SET ";
            $sSql .= "  item_num = item_num + :item_num ";
            $sSql .= "WHERE";
            $sSql .= "  item_id = :item_id AND ";
            $sSql .= "  user_id = :user_id ";
        }

        //SQL実行～取得
        $stmh = $pdo->prepare($sSql);
        $stmh->bindValue(':user_id',     $nUserId,          PDO::PARAM_INT);
        $stmh->bindValue(':item_id',     $nItemId,          PDO::PARAM_INT);
        $stmh->bindValue(':item_num',   $nItemNum,         PDO::PARAM_INT);
        $result = $stmh->execute();//成功したらtrueが入る


    } catch (PDOException $Exception) {

        //例外が発生したらエラーを出力
        die('実行エラー（' . __FUNCTION__."）：".$Exception->getMessage()."<br />");

    }

    return $result;

}

/****************************************
 * 数量変更
 * $nItemId ：商品ID
 * $nItemNum：商品数量
 * $nUserId ：ユーザID
 ****************************************/
function changeCart($nItemId, $nItemNum, $nUserId){

    //初期化
    $result = false;

    //データベース接続関数の呼び出し
    $pdo = db_connect();

    try {
        //数量変更の場合
        if($nItemNum > 0){
            //UPDATE文作成
            $sSql  = "";
            $sSql .= "UPDATE cart SET ";
            $sSql .= "  item_num = :item_num ";
            $sSql .= "WHERE";
            $sSql .= "  item_id = :item_id AND ";
            $sSql .= "  user_id = :user_id ";

            //SQL実行～取得
            $stmh = $pdo->prepare($sSql);
            $stmh->bindValue(':user_id',  $nUserId,  PDO::PARAM_INT);
            $stmh->bindValue(':item_id',  $nItemId,  PDO::PARAM_INT);
            $stmh->bindValue(':item_num', $nItemNum, PDO::PARAM_INT);
            $result = $stmh->execute();
        }
        //数量が0の場合は削除
        else {
            //DELETE文作成
            $sSql  = "";
            $sSql .= "DELETE FROM cart ";
            $sSql .= "WHERE";
            $sSql .= "  item_id = :item_id AND ";
            $sSql .= "  user_id = :user_id ";

            //SQL実行～取得
            $stmh = $pdo->prepare($sSql);
            $stmh->bindValue(':user_id',  $nUserId,  PDO::PARAM_INT);
            $stmh->bindValue(':item_id',  $nItemId,  PDO::PARAM_INT);
            $result = $stmh->execute();
        }

    } catch (PDOException $Exception) {

        //例外が発生したらエラーを出力
        die('実行エラー（' . __FUNCTION__."）：".$Exception->getMessage()."<br />");

    }
    return $result;
}

/****************************************
 * カート内クリア
 * $nUserId ：ユーザID
 ****************************************/
function clearCart($nUserId){

    //初期化
    $result = false;

    //データベース接続関数の呼び出し
    $pdo = db_connect();

    try {
        //DELETE文作成
        $sSql  = "";
        $sSql .= "DELETE FROM cart ";
        $sSql .= "WHERE";
        $sSql .= "  user_id = :user_id ";

        //SQL実行～取得
        $stmh = $pdo->prepare($sSql);
        $stmh->bindValue(':user_id',  $nUserId,  PDO::PARAM_INT);
        $result = $stmh->execute();

    } catch (PDOException $Exception) {

        //例外が発生したらエラーを出力
        die('実行エラー（' . __FUNCTION__."）：".$Exception->getMessage()."<br />");

    }
    return $result;
}

####################################################################################
### 注文関連
####################################################################################
/****************************************
 * 注文確定
 * $nUserId ：ユーザID
 ****************************************/
function compOrder($nUserId){

    //初期化
    $result = false;
    $orderDate = date("Y-m-d H:i:s");

    //データベース接続関数の呼び出し
    $pdo = db_connect();

    try {

        //カート内の商品情報を取得する
        $arrCart = selectCart($nUserId);

        //注文テーブルへデータを入れるSQL
        $sSql  = "";
        $sSql .= "INSERT INTO orders ";
        $sSql .= "  (user_id, item_id, item_num, sales_price, order_date) ";
        $sSql .= "VALUES ";
        $sSql .= "  (:user_id, :item_id, :item_num, :sales_price, :order_date) ";

        //SQL実行～取得
        foreach($arrCart as $arr){
            $stmh = $pdo->prepare($sSql);
            $stmh->bindValue(':user_id',     $nUserId,           PDO::PARAM_INT);
            $stmh->bindValue(':item_id',     $arr["item_id"],    PDO::PARAM_INT);
            $stmh->bindValue(':item_num',    $arr["item_num"],   PDO::PARAM_INT);
            $stmh->bindValue(':sales_price', $arr["item_price"], PDO::PARAM_INT);
            $stmh->bindValue(':order_date',  $orderDate,         PDO::PARAM_STR);
            $stmh->execute();
        }

        //カート内クリア
        clearCart($nUserId);


    } catch (PDOException $Exception) {

        //例外が発生したらエラーを出力
        die('実行エラー（' . __FUNCTION__."）：".$Exception->getMessage()."<br />");

    }
}

?>