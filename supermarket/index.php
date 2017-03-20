<!DOCTYPE html>
<html lang="ch">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
    <title>超市管理系统</title>
</head>
<body>
<?php
    $counter="";
    $password="";
?>
    <div class="main">
        <div class="header">
            <div class="system">小型超市管理系统1.0</div>
            <div class="datetime">2016-12-28</div>
            <div class="login">用户yangjile</div>
        </div>
        <div class="tab">
            <ul>
                <li><a href="#">首页</a></li>
                <li><a href="#">商品录入</a></li>
                <li><a href="#">收银业务</a></li>
                <li><a href="#">进货管理</a></li>
                <li><a href="#">销售管理</a></li>
                <li><a href="#">库存管理</a></li>
                <li><a href="#">人员管理</a></li>
            </ul>
        </div>
        <div class="container">
            <div class="home">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <input type="text" name="counter" placeholder="账户" value="<?php echo $counter?>"><br>
                    <input type="password" name="password" placeholder="密码" value="<?php echo $password?>"><br>
                    <input type="submit" value="登录" id="btnLogin">
                </form>
                <?php
                echo "<h2>您输入的内容是:</h2>";
                echo $counter;
                echo "<br>";
                echo $password;
                ?>
            </div>
            <div class="entering">
                <table border="1">
                    <tr>
                        <th>商品名称</th>
                        <th>价格</th>
                        <th>条形码</th>
                        <th>促销价格</th>
                        <th>促销起日期</th>
                        <th>促销止日期</th>
                        <th>允许打折</th>
                        <th>库存数量</th>
                        <th>库存报警数量</th>
                        <th>计划进货数</th>
                        <th>允许销售</th>
                    </tr>
                    <tr>
                        <td contentEditable="true"></td>
                        <td contentEditable="true"></td>
                        <td contentEditable="true"></td>
                        <td contentEditable="true"></td>
                        <td contentEditable="true"></td>
                        <td contentEditable="true"></td>
                        <td contentEditable="true"></td>
                        <td contentEditable="true"></td>
                        <td contentEditable="true"></td>
                        <td contentEditable="true"></td>
                        <td contentEditable="true"></td>
                    </tr>
                </table>
            </div>
            <div class="cashier">
                <table border="1">
                    <tr>
                        <th>商品名</th>
                        <th>单价</th>
                        <th>数量</th>
                        <th>总价</th>
                    </tr>
                    <tr>
                        <td contentEditable="true"></td>
                        <td contentEditable="true"></td>
                        <td contentEditable="true"></td>
                        <td contentEditable="true"></td>
                    </tr>
                </table>
            </div>
            <div class="stock">
                <table border="1">
                    <tr>
                        <th>商品名</th>
                        <th>进货数量</th>
                    </tr>
                    <tr>
                        <td contentEditable="true"></td>
                        <td contentEditable="true"></td>
                    </tr>
                </table>
            </div>
            <div class="sale">
                <table border="1">
                    <tr>
                        <th>商品名</th>
                        <th>正常销售</th>
                        <th>促销</th>
                        <th>限量</th>
                        <th>限期</th>
                        <th>禁止销售</th>
                    </tr>
                    <tr>
                        <td contentEditable="true"></td>
                        <td contentEditable="true"></td>
                        <td contentEditable="true"></td>
                        <td contentEditable="true"></td>
                        <td contentEditable="true"></td>
                        <td contentEditable="true"></td>
                    </tr>
                </table>
            </div>
            <div class="repertory">
                <table>
                    <tr>
                        <th>商品名</th>
                        <th>库存状态</th>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
            </div>
            <div class="staff">
                <table border="1">
                    <tr>
                        <th>员工</th>
                        <th>权限管理</th>
                    </tr>
                    <tr>
                        <td contentEditable="true"></td>
                        <td contentEditable="true"></td>
                    </tr>
                </table>
                <table border="1">
                    <th>会员</th>

                </table>
                <table border="1">
                    <th>供货商</th>
                </table>
                <table border="1">
                    <th>厂商</th>
                </table>
            </div>
        </div>
    </div>
    <script src="js/Data.js"></script>
</body>
</html>