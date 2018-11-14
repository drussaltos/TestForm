<?php $this->layout('layout') ?>

<div class="main-content">
    <div class="container">
        <div class="leave-comment mr0"><!--leave comment-->
            <h3 class="text-uppercase">Форма</h3>
            <br>
            <?php echo flash(); ?>
            <form action="" id="ajax_form" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="inputName">Имя:</label>
                    <input type="text" class="form-control" name="username" placeholder="Введите имя">
                </div>
                <div class="form-group">
                    <label for="inputEmail">Адрес email:</label>
                    <input type="text" class="form-control" name="email" placeholder="Введите email">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" style="display: none;" name="check" >
                </div>
                <div class="form-group">
                    <label>Картинка</label>
                    <input class="file-input" type="file" id="exampleInputEmail1" name="image">
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" onchange="document.getElementById('submit').disabled = !this.checked" checked="checked">Я согласен с условиями обработки персональных данных и т.д.
                    </label>
                </div>
                <div class="form-group">
                    <div class="g-recaptcha" data-sitekey="6LdBcXoUAAAAAMuyCS7tPPmX1JHKSvMluLu7x0WZ"></div>
               </div>
                <button type="submit" id='submit' class="btn btn-success">Отправить</button>
            </form>
<!--            <div id="result_form"></div>-->
        </div> 
    </div>
</div>
