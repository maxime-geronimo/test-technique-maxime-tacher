
<?php echo $this->JqueryFileUpload->loadCss(); ?>
<?php echo $this->JqueryFileUpload->loadScripts(); ?>

<div class="gallery scale-transition scale-out">
    <?php
    if(!empty($medias)){
        foreach ($medias as $media){ ?>
            <div class="picture shadow-hover">
                <?= $this->Html->image($media->url, ['data-id'=>$media->id, 'alt'=>$media->name, 'title'=>$media->name]); ?>
                <div class="set-as-default">
                    <a href="#">mettre par défaut</a>
                </div>
            </div>
        <?php  }
    }else{
        echo "<h5 class='no-image'>Aucune image</h5>";
    }
    ?>
</div>

<div id="progress_bar" class="progress">
    <div class="determinate" style="width: 0%">0</div>
</div>

<div class="btn-add scale-transition scale-out">
    <a class="btn-floating btn waves-effect waves-light cyan2 tooltipped" data-position="left" data-tooltip="Ajouter des images gif / png / jpeg (5M max)">
        <!--<i class="material-icons">add</i>-->
        <?= $this->Html->image('icons/add.svg') ?>
    </a>
    <input id="fileupload" type="file" name="files[]" multiple="">
</div>


<script>
    $(document).ready(function(e){
        init_medias_list(<?= json_encode($medias);?>);
    })
</script>
