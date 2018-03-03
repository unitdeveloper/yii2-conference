<?php $model = new \app\models\form\SearchForm(); ?>
<div id="aside" class="span3">
    <!-- Begin Right Sidebar -->
    <noscript>Javascript is required to use <a href="http://gtranslate.net/">GTranslate</a> <a href="http://gtranslate.net/">multilingual website</a> and <a href="http://gtranslate.net/">translation delivery network</a></noscript>

    <script type="text/javascript">
        /* <![CDATA[ */
        eval(function(p,a,c,k,e,r){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('6 7(a,b){n{4(2.9){3 c=2.9("o");c.p(b,f,f);a.q(c)}g{3 c=2.r();a.s(\'t\'+b,c)}}u(e){}}6 h(a){4(a.8)a=a.8;4(a==\'\')v;3 b=a.w(\'|\')[1];3 c;3 d=2.x(\'y\');z(3 i=0;i<d.5;i++)4(d[i].A==\'B-C-D\')c=d[i];4(2.j(\'k\')==E||2.j(\'k\').l.5==0||c.5==0||c.l.5==0){F(6(){h(a)},G)}g{c.8=b;7(c,\'m\');7(c,\'m\')}}',43,43,'||document|var|if|length|function|GTranslateFireEvent|value|createEvent||||||true|else|doGTranslate||getElementById|google_translate_element2|innerHTML|change|try|HTMLEvents|initEvent|dispatchEvent|createEventObject|fireEvent|on|catch|return|split|getElementsByTagName|select|for|className|goog|te|combo|null|setTimeout|500'.split('|'),0,{}))
        /* ]]> */
    </script>


    <div id="google_translate_element2"></div>
    <script type="text/javascript">function googleTranslateElementInit2() {new google.translate.TranslateElement({pageLanguage: 'uk', autoDisplay: false}, 'google_translate_element2');}</script>
    <script type="text/javascript" src="http://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit2"></script>

    <a href="#" onclick="doGTranslate('uk|uk');return false;" title="Ukrainian" class="flag nturl" style="background-position:-100px -400px;"><img src="/img/translate/blank.png" height="16" width="16" alt="Ukrainian" /></a>
    <a href="#" onclick="doGTranslate('uk|en');return false;" title="English" class="flag nturl" style="background-position:-0px -0px;"><img src="/img/translate/blank.png" height="16" width="16" alt="English" /></a>
    <a href="#" onclick="doGTranslate('uk|pl');return false;" title="Polish" class="flag nturl" style="background-position:-200px -200px;"><img src="/img/translate/blank.png" height="16" width="16" alt="Polish" /></a>
    <a href="#" onclick="doGTranslate('uk|ru');return false;" title="Russian" class="flag nturl" style="background-position:-500px -200px;"><img src="/img/translate/blank.png" height="16" width="16" alt="Russian" /></a>
    <div class="search mod_search63">

        <?php $form = \yii\widgets\ActiveForm::begin(['action' => \yii\helpers\Url::to(['matherial/search']), 'method' => 'GET']) ?>

        <?= $form->field($model, 'q')->textInput(['class' => 'inputbox search-query', 'type' => 'search', 'placeholder' => 'Пошук...'])->label(''); ?>

        <?php $form = \yii\widgets\ActiveForm::end(); ?>

    </div>
    <?php if (!empty($archive)) : ?>
    <div class="well "><h3 class="page-header">Останні матеріали</h3>
        <div class="custom"  >
            <p><a href="<?=\yii\helpers\Url::to(['/archive/view-pdf', 'id' => $archive->id])?>" target="_blank">
                    <img src="<?=$archive->getImage()?>" alt="5 2017" />
                </a>
            </p>
        </div>
    </div>
    <?php endif; ?>
    <div class="well "><h3 class="page-header">Контакти</h3>

        <div class="custom"  >
            <p>
                <strong>Адреса:</strong>
                Луцький НТУ, кафедра АУВП, вул. Потебні, 56, м. Луцьк, 43018, Україна<br />
                <strong>Телефон:</strong>
                (0332) 26-14-09<br />
                <strong>Email:</strong>
                auvp@lntu.edu.ua
            </p>
        </div>
    </div>
    <!-- End Right Sidebar -->
</div>