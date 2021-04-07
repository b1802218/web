<?php
####################################################################################
### ユーザ関連
####################################################################################
/****************************************
 * ログインチェック
 * $sLoginId　：ログインID（未指定は空白）
 * $sLoginPass：ログインパスワード（未指定は空白）
 ****************************************/
function loginCheck($slogin_id = "", $sLoginPass = ""){

    //初期化
    $arrUser = array();

    //データベース接続関数の呼び出し
    $pdo = db_connect2();

    try {
        //変数の準備
        $sSql  = "";

        //データ検索のSQLを作成
        $sSql .= "SELECT ";
        $sSql .= "   * ";
        $sSql .= "FROM ";
        $sSql .= "   admin ";
        $sSql .= "WHERE ";
        $sSql .= "  login_id = :login_id AND ";
        $sSql .= "  login_pass = :login_pass ";


        //ステートメントハンドラを作成
        $stmh = $pdo->prepare($sSql);
        $stmh->bindValue(':login_id',   $slogin_id,   PDO::PARAM_STR);
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
 * ログインユーザ名取得
 * $sLoginId　：ログインID
 * $sLoginPass：ログインパスワード
 ****************************************/
function getUserName($slogin_id = "", $sLoginPass = ""){

    //初期化
    $arrUser = array();
    $sUserName = "";

    //データベース接続関数の呼び出し
    $pdo = db_connect2();

    try {
        //変数の準備
        $sSql  = "";

        //データ検索のSQLを作成
        $sSql .= "SELECT ";
        $sSql .= "   login_name ";
        $sSql .= "FROM ";
        $sSql .= "   admin ";
        $sSql .= "WHERE ";
        $sSql .= "  login_id = :login_id AND ";
        $sSql .= "  login_pass = :login_pass ";


        //ステートメントハンドラを作成
        $stmh = $pdo->prepare($sSql);
        $stmh->bindValue(':login_id',   $slogin_id,   PDO::PARAM_STR);
        $stmh->bindValue(':login_pass', $sLoginPass, PDO::PARAM_STR);

        //SQL文の実行
        $stmh->execute();

        //実行結果を取得
        $arrUser = $stmh->fetch(PDO::FETCH_ASSOC);

        //ユーザ名取得
        $sUserName = $arrUser["login_name"];


    } catch (PDOException $Exception) {

        //例外が発生したらエラーを出力
        die('実行エラー（' . __FUNCTION__."）：".$Exception->getMessage()."<br />");

    }

    return $sUserName;

}

/****************************************
 * 会員一覧取得
 ****************************************/
function selectmember($kkeyword, $kkeyword2, $kkeyword3){

    //初期化
    $arrmember = array();
    $sWhere = "";

    //データベース接続関数の呼び出し
    $pdo = db_connect2();

    try {
        //変数の準備
        $sSql  = "";

        //データ検索のSQLを作成
        $sSql .= "SELECT ";
        $sSql .= "   * ";
        $sSql .= "FROM ";
        $sSql .= "   customer ";

        //データ検索の条件
        if($kkeyword != ""){
            //キーワード
            $sWhere .= ($sWhere == "") ? "WHERE " : "AND ";
            $sWhere .= "last_name LIKE :last_name OR first_name LIKE :first_name";
        }
        if($kkeyword2 != ""){
            //住所
            $sWhere .= ($sWhere == "") ? "WHERE " : "AND ";
            $sWhere .= "Saddress LIKE :Saddress ";
        }
        if($kkeyword3 != ""){
            //メールアドレス
            $sWhere .= ($sWhere == "") ? "WHERE " : "AND ";
            $sWhere .= "email LIKE :email ";
        }

        //ステートメントハンドラを作成
        $stmh = $pdo->prepare($sSql.$sWhere);

        //バインドの実行
        if($kkeyword != ""){
            //名前
            $stmh->bindValue(':last_name',  "%".$kkeyword."%", PDO::PARAM_STR);
            $stmh->bindValue(':first_name',  "%".$kkeyword."%", PDO::PARAM_STR);
        }
        if($kkeyword2 != ""){
            //住所
            $stmh->bindValue(':Saddress',  "%".$kkeyword2."%", PDO::PARAM_STR);
        }
        if($kkeyword3 != ""){
            //メールアドレス
            $stmh->bindValue(':email',  "%".$kkeyword3."%", PDO::PARAM_STR);
        }

        //SQL文の実行
        $stmh->execute();

        //実行結果を取得
        $arrmember = $stmh->fetchAll(PDO::FETCH_ASSOC);


    } catch (PDOException $Exception) {

        //例外が発生したらエラーを出力
        die('実行エラー（' . __FUNCTION__."）：".$Exception->getMessage()."<br />");

    }

    return $arrmember;

}

/****************************************
 * 会員編集
 ****************************************/
function updatemember($sId,$sFirstName, $sLastName,$sPcode,$sSaddress,$sPnumber,$semail,$sloginPass){



    //データベース接続関数の呼び出し
    $pdo = db_connect2();

    try {
    //SQLを作成
    $sSql = "UPDATE customer SET
        first_name = :first_name, 
        last_name = :last_name,
        Pcode = :Pcode,
        Saddress = :Saddress,
        Pnumber = :Pnumber,
        email = :email,
        login_pass = :login_pass
        WHERE
        id = :id";
        
    
        //ステートメントハンドラを作成
        $stmh = $pdo->prepare($sSql);
        //バインドの実行
        $stmh->bindValue(':id',  $sId,  PDO::PARAM_INT);

            $stmh->bindValue(':first_name',  $sFirstName,  PDO::PARAM_STR);
        
            $stmh->bindValue(':last_name',  $sLastName,  PDO::PARAM_STR);

            $stmh->bindValue(':Pcode',  $sPcode,  PDO::PARAM_STR);

            $stmh->bindValue(':Saddress',  $sSaddress,  PDO::PARAM_STR);
        
            $stmh->bindValue(':Pnumber',  $sPnumber,  PDO::PARAM_STR);

            $stmh->bindValue(':email',  $semail,  PDO::PARAM_STR);

            $stmh->bindValue(':login_pass',  $sloginPass,  PDO::PARAM_STR);
        

        //SQL文の実行
    $stmh->execute();

    //実行結果を取得
    return true;

} catch (PDOException $Exception) {

    //例外が発生したらエラーを出力
    die('実行エラー（' . __FUNCTION__."）：".$Exception->getMessage()."<br />");
    return false;
}

}

/****************************************
 * 会員詳細取得
 ****************************************/
function memberselect($sId){

    //初期化
    $arrmember = array();

    //データベース接続関数の呼び出し
    $pdo = db_connect2();

    try {
        //変数の準備
        $sSql  = "";

        //データ検索のSQLを作成
        $sSql .= "SELECT ";
        $sSql .= "   id, ";
        $sSql .= "   last_name, ";
        $sSql .= "   first_name, ";
        $sSql .= "   Pcode, ";
        $sSql .= "   Saddress, ";
        $sSql .= "   Pnumber, ";
        $sSql .= "   email, ";
        $sSql .= "   login_pass ";
        $sSql .= "FROM ";
        $sSql .= "   customer ";
        $sSql .= "WHERE ";
        $sSql .= "   id = :id ";


        //ステートメントハンドラを作成
        $stmh = $pdo->prepare($sSql);

        $stmh->bindValue(':id',  $sId,  PDO::PARAM_INT);

        //SQL文の実行
        $stmh->execute();

        //実行結果を取得
        $arrmember = $stmh->fetchAll(PDO::FETCH_ASSOC);


    } catch (PDOException $Exception) {

        //例外が発生したらエラーを出力
        die('実行エラー（' . __FUNCTION__."）：".$Exception->getMessage()."<br />");

    }

    return $arrmember;

}

/****************************************
 * 会員削除
 ****************************************/
function clearcustomer($sId){

    $result = false;
	//データベース接続関数の呼び出し
	$pdo = db_connect2();

	try {
		//データ検索の条件
		$sSql  = "";
        $sSql .= "DELETE FROM customer ";
        $sSql .= "WHERE";
        $sSql .= "  id = :id ";
		
		//ステートメントハンドラを作成
		$stmh = $pdo->prepare($sSql);
		
		//バインドの実行
		$stmh->bindValue(':id',  $sId,  PDO::PARAM_INT);
		//SQL文の実行
		$stmh->execute();

		$result = $stmh->execute();


	
	} catch (PDOException $Exception) {
	
		//例外が発生したらエラーを出力
		die('実行エラー :' . $Exception->getMessage()."<br />");

    }
    return $result;

}

####################################################################################
### 商品関連
####################################################################################
/****************************************
 * 商品一覧取得
 ****************************************/
function selectItem($keyword, $categoryId, $keyword2, $keyword3,$keyword4){

    //初期化
    $arrItem = array();
    $sWhere = "";

    //データベース接続関数の呼び出し
    $pdo = db_connect2();

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
            $sWhere .= "A.item_price > :item_price1 ";
        }
        if($keyword4 != ""){
            //キーワード
            $sWhere .= ($sWhere == "") ? "WHERE " : "AND ";
            $sWhere .= "A.item_price < :item_price2 ";
        }
        if($keyword3 != ""){
            //キーワード
            $sWhere .= ($sWhere == "") ? "WHERE " : "AND ";
            $sWhere .= "A.flag = :flag ";
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
        if($keyword4 != ""){
            //カテゴリID
            $stmh->bindValue(':item_price2',  $keyword4, PDO::PARAM_INT);
        }
        if($keyword3 != ""){
            //カテゴリID
            $stmh->bindValue(':flag',  $keyword3, PDO::PARAM_INT);
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
 * カテゴリ取得
 ****************************************/
function getCategory(){

    //初期化
    $arrCategory = array();

    //データベース接続関数の呼び出し
    $pdo = db_connect2();

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

/****************************************
 * 詳細
 ****************************************/

function itemselect($nItemId){

    //初期化
    $arrItem = array();

    //データベース接続関数の呼び出し
    $pdo = db_connect2();

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
 * 商品追加
 ****************************************/
function insertitem($sitem_id, $sitem_name,$sitem_exp,$sitem_price,$sitem_stock,$scategory_id){

	//データベース接続関数の呼び出し
	$pdo = db_connect2();

	try {
		//データ検索の条件
		$sSql = "INSERT INTO item (item_id, item_name, item_exp, item_price, item_stock, category_id)
				VALUES (:item_id, :item_name, :item_exp, :item_price, :item_stock, :category_id)";
		
		//ステートメントハンドラを作成
		$stmh = $pdo->prepare($sSql);
		
		//バインドの実行
		$stmh->bindValue(':item_id',  $sitem_id,  PDO::PARAM_STR);
        $stmh->bindValue(':item_name', $sitem_name, PDO::PARAM_STR);
        $stmh->bindValue(':item_exp', $sitem_exp, PDO::PARAM_STR);
        $stmh->bindValue(':item_price', $sitem_price, PDO::PARAM_STR);
        $stmh->bindValue(':item_stock', $sitem_stock, PDO::PARAM_STR);
        $stmh->bindValue(':category_id', $scategory_id, PDO::PARAM_STR);

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
/****************************************
 * 削除処理
 ****************************************/
function clearItem($nItemId){

    $result = false;
	//データベース接続関数の呼び出し
	$pdo = db_connect2();

	try {
		//データ検索の条件
		$sSql  = "";
        $sSql .= "DELETE FROM item ";
        $sSql .= "WHERE";
        $sSql .= "  item_id = :item_id ";
		
		//ステートメントハンドラを作成
		$stmh = $pdo->prepare($sSql);
		
		//バインドの実行
		$stmh->bindValue(':item_id',  $nItemId,  PDO::PARAM_STR);
		//SQL文の実行
		$stmh->execute();

		$result = $stmh->execute();


	
	} catch (PDOException $Exception) {
	
		//例外が発生したらエラーを出力
		die('実行エラー :' . $Exception->getMessage()."<br />");

    }
    return $result;

}

/****************************************
 * 商品編集
 ****************************************/

function upDataItem($sitem_id, $sitem_name,$sitem_exp,$sitem_price,$sitem_stock,$scategory_id,$sflag){

//データベース接続関数の呼び出し
$pdo = db_connect2();

try {
    //データ検索のSQLを作成
    $sSql = "UPDATE item 
    SET
        item_name = :item_name, 
        item_exp = :item_exp,
        item_price = :item_price,
        item_stock = :item_stock,
        category_id = :category_id,
        flag = :flag
    WHERE
        item_id = :item_id
";



    //ステートメントハンドラを作成
    $stmh = $pdo->prepare($sSql);
    //バインドの実行
    $stmh->bindValue(':item_id',  $sitem_id,  PDO::PARAM_INT);

        $stmh->bindValue(':item_name',  $sitem_name,  PDO::PARAM_STR);

        $stmh->bindValue(':item_exp',  $sitem_exp,  PDO::PARAM_STR);

        $stmh->bindValue(':item_price',  $sitem_price,  PDO::PARAM_INT);

        $stmh->bindValue(':item_stock',  $sitem_stock,  PDO::PARAM_INT);

        $stmh->bindValue(':category_id',  $scategory_id,  PDO::PARAM_INT);

        $stmh->bindValue(':flag',  $sflag,  PDO::PARAM_INT);        


    //SQL文の実行
    $stmh->execute();

    //実行結果を取得
    return true;

} catch (PDOException $Exception) {

    //例外が発生したらエラーを出力
    die('実行エラー（' . __FUNCTION__."）：".$Exception->getMessage()."<br />");
    return false;
}


}

####################################################################################
### カート関連
####################################################################################
/****************************************
 * カート一覧取得
 * $nUserId：ユーザID
 ****************************************/
function Cartselect($nkeyword = "",$nkeyword2 = ""){



    //初期化
    $arrdate = array();
    $sWhere = "";

    //データベース接続関数の呼び出し
    $pdo = db_connect2();

    try {
        //データ検索のSQLを作成
        $sSql  = "";
        $sSql .= "SELECT ";
        $sSql .= "   A.order_id, ";
        $sSql .= "   B.last_name, ";
        $sSql .= "   B.first_name, ";
        $sSql .= "   C.item_name, ";
        $sSql .= "   A.item_num, ";
        $sSql .= "   A.sales_price, ";
        $sSql .= "   A.order_date ";
        $sSql .= "FROM ";
        $sSql .= "   orders A ";
        $sSql .= "LEFT JOIN ";
        $sSql .= "   customer B ";
        $sSql .= "ON ";
        $sSql .= "   A.user_id = B.id ";
        $sSql .= "LEFT JOIN ";
        $sSql .= "   item C ";
        $sSql .= "ON ";
        $sSql .= "   A.item_id = C.item_id ";


        
        //データ検索の条件
        if($nkeyword != ""){
            //キーワード
            $sWhere .= ($sWhere == "") ? "WHERE " : "AND ";
            $sWhere .= "A.order_id = :order_id ";
        }
        if($nkeyword2 != ""){
            //キーワード
            $sWhere .= ($sWhere == "") ? "WHERE " : "AND ";
            $sWhere .= "B.last_name LIKE :last_name OR B.first_name LIKE :first_name";
        }


        //ステートメントハンドラを作成
        $stmh = $pdo->prepare($sSql.$sWhere);

        //バインドの実行
        if($nkeyword != ""){
            //キーワード
            $stmh->bindValue(':order_id',  $nkeyword, PDO::PARAM_STR);
        }
        if($nkeyword2 != ""){
            //カテゴリID
            $stmh->bindValue(':last_name',  "%".$nkeyword2."%", PDO::PARAM_STR);
            $stmh->bindValue(':first_name',  "%".$nkeyword2."%", PDO::PARAM_STR);
        }

        $stmh->execute();
        $arrdate = $stmh->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $Exception) {

        //例外が発生したらエラーを出力
        die('実行エラー（' . __FUNCTION__."）：".$Exception->getMessage()."<br />");

    }

    return $arrdate;

}
/****************************************
 * カート一覧取得
 * $nUserId：ユーザID
 ****************************************/
function Cartselect2($norderId){



    //初期化
    $arrdate = array();
    $sWhere = "";

    //データベース接続関数の呼び出し
    $pdo = db_connect2();

    try {
        //データ検索のSQLを作成
        $sSql  = "";
        $sSql .= "SELECT ";
        $sSql .= "   A.order_id, ";
        $sSql .= "   B.last_name, ";
        $sSql .= "   B.first_name, ";
        $sSql .= "   C.item_name, ";
        $sSql .= "   A.item_num, ";
        $sSql .= "   A.sales_price, ";
        $sSql .= "   A.order_date ";
        $sSql .= "FROM ";
        $sSql .= "   orders A ";
        $sSql .= "LEFT JOIN ";
        $sSql .= "   customer B ";
        $sSql .= "ON ";
        $sSql .= "   A.user_id = B.id ";
        $sSql .= "LEFT JOIN ";
        $sSql .= "   item C ";
        $sSql .= "ON ";
        $sSql .= "   A.item_id = C.item_id ";
        $sSql .= "WHERE ";
        $sSql .= "   A.order_id = :order_id ";


        //ステートメントハンドラを作成
        $stmh = $pdo->prepare($sSql.$sWhere);

        //バインドの実行
            $stmh->bindValue(':order_id',  $norderId, PDO::PARAM_STR);


        $stmh->execute();
        $arrdate = $stmh->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $Exception) {

        //例外が発生したらエラーを出力
        die('実行エラー（' . __FUNCTION__."）：".$Exception->getMessage()."<br />");

    }

    return $arrdate;

}
/****************************************
 * 注文取り消し
 * $nUserId：ユーザID
 ****************************************/
function clearorder($norderId){

    $result = false;
	//データベース接続関数の呼び出し
	$pdo = db_connect2();

	try {
		//データ検索の条件
		$sSql  = "";
        $sSql .= "DELETE FROM orders ";
        $sSql .= "WHERE";
        $sSql .= "  order_id = :order_id ";
		
		//ステートメントハンドラを作成
		$stmh = $pdo->prepare($sSql);
		
		//バインドの実行
		$stmh->bindValue(':order_id',  $norderId,  PDO::PARAM_INT);
		//SQL文の実行
		$stmh->execute();

		$result = $stmh->execute();


	
	} catch (PDOException $Exception) {
	
		//例外が発生したらエラーを出力
		die('実行エラー :' . $Exception->getMessage()."<br />");

    }
    return $result;

}
?>