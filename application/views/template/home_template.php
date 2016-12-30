<!DOCTYPE html>
<html>
<head>
<title>Survey</title>
<meta name="KeyWords" content="">
<meta name="Description" content="">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&amp;subset=cyrillic" rel="stylesheet"> 
<script src="/js/jquery-2.1.1.min.js"></script>
<script src="/js/code.js"></script>

<script src="/js/public/layout.js"></script>
<link href="/css/loader.css" rel="stylesheet" type="text/css">

<link href="/css/css.css" type="text/css" rel="stylesheet">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" type="text/css" /> 
</head>
<body>
  <!--wrapper-->
  <div id="wrapper">
    <!--header-->
    <div id="header">
      <div class="in"> 
        <?php if (uri(2) == 'survey'): ?>
          <div class="logo"><a href="#"><img src="/img/logo2.png" alt="#"></a></div>
          <div class="m_ctrl">Q&amp;A</div>
          <div class="fog">
            <div class="menu_wr">
              <div class="close"></div>
              <div class="title">FAQ</div>
              <div class="menu">
              <?php if (!empty($faq_categories)): ?>
                <?php foreach ($faq_categories as $item): ?>
                  <a href="/<?=$lang?>/faq/cat/<?=union_uri($item['id'])?>"><?=$item["name"]?></a> 
                <?php endforeach ?> 
              <?php endif ?> 
              </div>
            </div>
          </div>
          <div class="lang">
            <div class="lang_vis"><?=$lang?> </div>
            <div class="lang_content">
              <?php foreach ($lang_arr as $key => $value): ?>
                <a href="<?=base_url($value.'/'._current_url_lang(uri_string()))?>"><?=$value?></a>
              <?php endforeach ?> 
            </div>
          </div>
        <?php else: ?>
        <div class="logo"><a href="#"><img src="/img/logo1.png" alt="#"></a></div>
          <div class="lang">
            <div class="lang_vis"> 
              <?=$lang?> 
            </div>
            <div class="lang_content">
              <?php foreach ($lang_arr as $key => $value): ?>
                <a href="<?=base_url($value.'/'._current_url_lang(uri_string()))?>"><?=$value?></a>
              <?php endforeach ?> 
            </div>
          </div>
        <?php endif ?>
         

      </div>
    </div><!--/header-->
    <!--main-->
    <div id="main">
      <div class="in">
        <?=$content?>
        <div class="clear"></div>
      </div>
    </div><!--/main-->
  </div><!--/wrapper-->
  <!--footer-->
  <div id="footer">
    <div class="in">
      <div class="copy">
        © 2016 – 2016 Survey powered by <strong>Merbau&nbsp;Group</strong><br>
        All rights reserved.
      </div>
    </div>
  </div><!--/footer-->
</body>
</html>