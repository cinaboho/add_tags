<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tags Input</title>
    <style>
        .tags-container {
            display: flex;
            flex-wrap: wrap;
            border: 1px solid #ccc;
            padding: 5px;
            border-radius: 4px;
        }
        .tag {
            background-color: #007bff;
            color: white;
            border-radius: 3px;
            padding: 5px 10px;
            margin: 2px;
            display: flex;
            align-items: center;
        }
        .tag .remove-tag {
            margin-left: 5px;
            cursor: pointer;
            color: white;
        }
        .helper-text {
            font-size: 0.9em;
            color: #555;
            margin-top: 5px;
        }
    </style>
</head>
<body>

<div class="tags">
    <datalist id="ListaitemsDatalist">
        <?php foreach ($categoria as $item): ?>
            <option value="<?= $item->categoria ?>" data-id="<?= $item->id_categoria ?>"></option>
        <?php endforeach; ?>
    </datalist>
    <div class="tags-container" id="tagsContainer">
        <!-- Tags will be added here -->
    </div>
    <input list="ListaitemsDatalist" name="item" id="item" type="text" class="form-control" placeholder="Agrega un item" aria-label="Search Nombre" required>
    <input type="text" id="cadenatags" name="cadenatags" class="form-control" placeholder="Tags agregados" readonly>
    <div class="helper-text">Selecciona un valor de la lista y presiona "Enter" para agregar el tag.</div>
</div>

<script>
    function updateTagString() {
        const tags = Array.from(document.querySelectorAll('.tags-container .tag'))
                          .map(tag => tag.textContent.replace('x', '').trim());
        document.getElementById('cadenatags').value = tags.join(', ');
    }

    document.getElementById('item').addEventListener('keypress', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault(); // Prevent default Enter behavior

            const input = this;
            const value = input.value.trim();
            const datalist = document.getElementById('ListaitemsDatalist');
            const options = Array.from(datalist.options).map(option => option.value);

            if (value) {
                if (options.includes(value)) {
                    // Create a new tag
                    const tag = document.createElement('div');
                    tag.className = 'tag';
                    tag.textContent = value;

                    // Button to remove the tag, represented by "x"
                    const removeBtn = document.createElement('span');
                    removeBtn.textContent = 'x';
                    removeBtn.className = 'remove-tag';
                    removeBtn.onclick = function () {
                        tag.remove();
                        updateTagString(); // Update tag string after removing
                    };

                    tag.appendChild(removeBtn);
                    document.getElementById('tagsContainer').appendChild(tag);

                    // Update tag string and clear the input
                    updateTagString();
                    input.value = '';
                } else {
                    // Show alert if value is not in the list
                    alert('Por favor, selecciona un item de la lista.');
                }
            }
        }
    });
</script>

</body>
</html>
