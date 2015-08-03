<div class="quiz-preview">
    <?php foreach ($quiz as $key => $value) { ?>
        <p><?php echo $value->getTitle(); ?></p>
        <ul>
            <?php foreach ($value->getQuestions() as $question => $data) {
                ?>
                <li><?php echo $data->getTitle(); ?></li>
                <?php }
            ?>
        </ul>
    <?php } ?>
</div>