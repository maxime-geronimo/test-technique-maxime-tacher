<!-- Modal Structure -->
<div id="modal-pic-editor" class="modal">
    <div class="modal-content">
        <div class="row">
            <div class="col s12 m5">
                <div class="picture">
                    <?= $this->Html->image('geronimo-logo.png'); ?>
                </div>
            </div>
            <div class="col s12 m7">
                <div class="input-field">
                    <input id="input-title" type="text" class="validate" placeholder="Titre" maxlength="255">
                </div>
                <div>
                    <label for="description">Description</label>
                    <textarea id="textarea-description" ></textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <a id="modal-btn-edit" class="waves-effect waves-light btn-large cyan2"><i class="material-icons left">border_color</i>Éditer</a>
        <a id="modal-btn-delete" class="waves-effect waves-light btn-large pink2"><i class="material-icons left">delete</i>Supprimer</a>
    </div>
</div>