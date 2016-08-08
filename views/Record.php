<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>明細</title>
    <script src="<?= $jsRoot ?>/jquery-2.1.1.min.js"></script>	
    <script src="<?= $jsRoot ?>/bootstrap.min.js"></script>
    <script src="<?= $jsRoot ?>/jquery.prettyPhoto.js"></script>
    <script src="<?= $jsRoot ?>/jquery.isotope.min.js"></script>  
    <script src="<?= $jsRoot ?>/wow.min.js"></script>
    <script src="<?= $jsRoot ?>/functions.js"></script>

  </head>
  
  <body>
     <h1 style="color: red;" align="center">交易明細</h1>
      <form id="form1" name="form1" method="post" action="<?= $root ?>/#/#">
        <!--table1-->
        <table width="320" border="1" align="center" cellpadding="5" cellspacing="0" bgcolor="#000000">
          <tr>
            <td colspan="2" align="center" bgcolor="#77FF00"><font color="#000000">輸入您的帳戶查詢</font></td>
          </tr>
          <tr>
            <td width="80" align="center" valign="baseline" bgcolor="#FFFFFF"><font color="#000000">出入款</font></td>
            <td width="80" align="center" valign="baseline" bgcolor="#AAAAAA"><font color="#000000">帳目明細</font></td>          
          </tr>
          <tr>
            <td colspan="2" width="80" align="center" valign="baseline" bgcolor="#FFFFFF"><font color="#000000">帳戶</font></td>
          </tr>
          <tr>
            <td colspan="2" width="80" align="center" valign="baseline" bgcolor="#FFFFFF"><input type="text" name="Name" id="Name" value=""  style= "color:#000000 ; width:250px; text-align:center;" placeholder="請輸入帳戶" /></td>
          </tr>
          <tr>
            <td colspan="2" align="center" bgcolor="#77FF00">
            <input type="submit" name="btnQuery" id="btnQuery" value="查詢"   style=background-color:pink;color:#000000 />
            </td>
          </tr>
        </table><!--table1-->
      </form>
      <br>
    <!--table2-->
    <table  border="1" align="center" cellpadding="5" cellspacing="0" bgcolor="#000000">
      <tr>
        <td colspan="5" align="center" bgcolor="#77FF00"><font color="#000000">明細</font></td>
      </tr>
      <tr>
        <td width="80" align="center" valign="baseline" bgcolor="#FFFFFF"><font color="#000000">帳戶</font></td>
        <td width="80" align="center" valign="baseline" bgcolor="#FFFFFF"><font color="#000000">時間</font></td>
        <td width="80" align="center" valign="baseline" bgcolor="#FFFFFF"><font color="#000000">支出</font></td>
        <td width="80" align="center" valign="baseline" bgcolor="#FFFFFF"><font color="#000000">收入</font></td>
        <td width="80" align="center" valign="baseline" bgcolor="#FFFFFF"><font color="#000000">餘額</font></td>
      </tr>
      <tr>
        <td width="80" align="center" valign="baseline" bgcolor="#FFFFFF"><font color="#000000">001</font></td>
        <td width="80" align="center" valign="baseline" bgcolor="#FFFFFF"><font color="#000000">2016-08-08</font></td>
        <td width="80" align="center" valign="baseline" bgcolor="#FFFFFF"><font color="red" >0</font></td>
        <td width="80" align="center" valign="baseline" bgcolor="#FFFFFF"><font color="blue">2000</font></td>
        <td width="80" align="center" valign="baseline" bgcolor="#FFFFFF"><font color="#000000">100000</font></td>
      </tr>

    </table><!--table2-->
  </body>
</html>