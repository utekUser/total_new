<div class="path-l">
    <div class="path-r">
        <div class="path-m">
            <div class="path">
                <?php echo $this->path; ?>
            </div>
            <div class="module-name">
                <?php echo $this->header; ?>
            </div>
        </div>
    </div>
</div>
<form action="" method="post" enctype="multipart/form-data" id="form">
    <?php foreach ($this->elements as $value) { ?>
    <?php if (!$value->getIgnore() && preg_match("/_Hidden/i", get_class($value))) { ?>
    <?php echo $value; ?>
    <?php } ?>
    <?php } ?>
    <div class="buttons">
        <a href="/admin/<?php echo $this->control; ?>">Назад</a>
        <input class="default" type="submit" name="_save" value="Сохранить" />
        <input type="submit" name="_addanother" value="Сохранить и добавить другой" />
        <input type="submit" name="_continue" value="Сохранить и продолжить редактирование" />
        <a href="/admin/<?php echo $this->control; ?>/delete/<?php echo $this->id; ?>" class="del">Удалить</a>
    </div>

    <?php /* <div class="new-row-l">
        <div class="new-row-r">
            <div class="new-row-m">
                Новая запись добавлена
            </div>
        </div>
    </div> */ ?>

    <?php
    $error = $this->form->getMessages();
    if (!empty($error)) {
    ?>
    <div class="error-l">
        <div class="error-r">
            <div class="error-m">
                <b>Пожалуйста, исправьте ошибки ниже</b>
            </div>
        </div>
    </div>
    <?php } ?>

    <div class="edit-div">
        <div class="edit-div-tl">
            <div class="edit-div-tr">
                <div class="edit-div-tm"></div>
            </div>
        </div>
        <div class="edit-div-ml">
            <div class="edit-div-mr">
                <div class="edit-div-mm">
                    <table class="edit-table" cellpadding="0" cellspacing="0">
                        <?php foreach ($this->elements as $value) { ?>
                        <?php
                        //                                    if (preg_match("/_Hidden/i", get_class($value))) {
                        //                                        echo "<pre>";
                        //                                        print_r($value);
                        //                                        echo "</pre>";
                        //                                    }
                        ?>
                        <?php // if (!$value->elmentHidden && $value->isFormDisplay()) { ?>
                        <?php if (!$value->getIgnore() && !preg_match("/_Hidden/i", get_class($value))) { ?>
                        <tr>
                            <td class="td-title"><?php echo $value->getLabel(); ?></td>
                            <td>
                                <?php // echo print_r($value->getMessages()); ?>
                                <?php
                                $error = $value->getMessages();
                                if (!empty($error)) {
                                $value->setAttrib('class', 'element-error');
                                echo '<ul class="errorlist">';
                                foreach ($error as $keyError => $valueError) {
                                ?>
                        <li><?php echo $valueError; ?></li>
                        <?php
                        }
                        echo '</ul>';
                        }
                        ?>
                        <?php echo $value; ?>
                        </td>
                        </tr>
                        <?php } ?>
                        <?php // } ?>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
        <div class="edit-div-bl">
            <div class="edit-div-br">
                <div class="edit-div-bm"></div>
            </div>
        </div> 
    </div>
    <div class="clear"></div>
    <div class="buttons">
        <a href="/admin/<?php echo $this->control; ?>">Назад</a>
        <input type="submit" name="_save" value="Сохранить" class="default" />
        <input type="submit" name="_addanother" value="Сохранить и добавить другой" />
        <input type="submit" name="_continue" value="Сохранить и продолжить редактирование" />
        <a href="/admin/<?php echo $this->control; ?>/delete/<?php echo $this->id; ?>" class="del">Удалить</a>

    </div>
</form>
<script type="text/javascript">document.getElementById("name").focus();</script>