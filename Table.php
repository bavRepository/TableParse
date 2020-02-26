<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="css/style.css" rel="stylesheet">
</head>

<body>

    <header class="menu">

        <div class="menuItems">
            Показать товары, у которых
        </div>
        <form id="ourForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <select class="custom-select" name="selectKindPrice">
                <option selected value="price">Розничная цена</option>
                <option value="wholesalePrice">Оптовая цена</option>
            </select>
            <div class="menuItems">от</div>
            <input class="custom-select inp" type="text" class="getel" name="priceRange1" value="1000" maxlength="12" />
            <div class="menuItems">до</div>
            <input class="custom-select inp" type="text" name="priceRange2" value="3000" maxlength="12" />

            <div class="menuItems">рублей на складе</div>
            <select class="custom-select .morethan" name="selectMoreLess">
                <option selected value="more">Более</option>
                <option value="less">Менее</option>
            </select>
            <input class="custom-select twenty" type="text" name="countItems" value="20" maxlength="12" />
            <div class="menuItems">штук</div>
            <input class="btn" type="button" id="send" value="ПОКАЗАТЬ ТОВАРЫ">

        </form>
        <div id="wrp">
            <div id="err"></div>
        </div>
    </header>

    <section class="product">
        <div class="container">
            <table class="tbl">
                <?php
                 echo $readyContent;
                ?>
            </table>
            <div class="calc">
                <?php
                 echo $resultBottomCalc;
                ?>
            </div>
        </div>
    </section>
    <script src="js/script.js"></script>
</body>
</html>