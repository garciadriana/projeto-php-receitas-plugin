<?php
/**
 * Plugin Name: Adriana Garcia Plugin
 * Description: Plugin desenvolvido pela Adriana para o teste de desenvolvimento da empresa LogicArts que consiste em gerenciamento e leitura de um menu de receitas
 * Version:     1.0
 * Author:      Adriana Garcia
 */

        add_action( 'init', 'create_post_type' );

        function create_post_type() {
            register_post_type( 'receitas',
                array(
                    'labels' => array(
                        'name' => __( 'Receitas' ),
                        'singular_name' => __( 'Receita' )
                    ),
                    'public' => true,
                )
            );
        }

add_action("admin_menu", "addMenu");
function addMenu(){
    add_menu_page("Options", "Administrador", 4, "admin-options", "adminMenu");
    add_submenu_page("admin-options", "Adicionar", "Adicionar Receita", 4, "add", "adicionar");
    add_submenu_page("admin-options", "Editar", "Editar Receita", 4, "edit", "editar");
    add_submenu_page("admin-options", "Excluir", "Excluir Receita", 4, "del", "deletar");
    add_submenu_page("", "Add", "Add", 4, "salvar_receita", "salvar_receita");
    add_submenu_page("", "Edit", "Edit", 4, "editar_receita", "editar_receita");
    add_submenu_page("", "Del", "Del", 4, "deletar_receita", "deletar_receita");
}

function adminMenu(){
   add_option("receitas", array());
    ?>
    <h1 align="center">Receitas Disponíveis</h1>
    <table border="2">
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Descrição</th>
        <th>Tempo</th>
        <th>Dificuldade</th>
        <th>Imagem</th>
        <th>Ingredientes</th>
        <th>Tipo</th>
    </tr>
    <?php foreach (get_option("receitas") as $indice=>$dados) { ?>
        <?php foreach ($dados as $dado) { ?>
    <tr>
        <td><?= $indice ?></td>
        <td><?= $dado["nomereceita"] ?></td>
        <td><?= $dado["descricao"] ?></td>
        <td><?= $dado["tempo"] ?></td>
        <td><?= $dado["dificuldade"] ?></td>
        <td><?= $dado["imagem"] ?></td>
        <td><?= $dado["ingredientes"] ?></td>
        <td><?= $dado["tipo"] ?></td>
        </td>
    </tr>
    <?php
        }
    }
}

function adicionar(){
    ?>
    <hr/>
    <h1 align="center">Adicionar Nova Receita</h1>
    <br>
    <form action="admin.php?page=salvar_receita" method="POST">
        <label for="nomereceita">Nome da Receita:</label>
        <input type="text" name="nomereceita" id="nomereceita"/><br/>
        <label for="descricao"><br/>Descrição: </label>
        <textarea rows="10" cols="100" name="descricao" id="descricao"></textarea><br/>
        <label for="tempo">Tempo de preparo: </label>
        <input type="text" name="tempo" id="tempo"/><br/>
        <label for="dificuldade">Dificuldade da receita: </label><br/>
        <input type="checkbox" name="dificuldade" id="dificuldade" value="facil"/>Fácil<br/>
        <input type="checkbox" name="dificuldade" id="dificuldade" value="medio"/>Médio<br/>
        <input type="checkbox" name="dificuldade" id="dificuldade" value="dificil"/>Dificil<br/>
        <label for="imagem">Imagem da Receita (coloque a URL completa): </label>
        <input type="text" name="imagem" id="imagem"/><br/>
        <label for="ingredientes">Ingredientes: </label>
        <textarea rows="10" cols="100" name="ingredientes" id="ingredientes"></textarea><br/>
        <label for="tipo">Tipo de Receita: </label><br/>
        <input type="radio" name="tipo" id="tipo" value="doce"/>Doce<br/>
        <input type="radio" name="tipo" id="tipo" value="salgado"/>Salgado<br/><br/>
        <input type="submit" name="adicionar" value="Adicionar">
    </form>
    <?php
}

function salvar_receita(){
    $id = $_POST['id'];
    $nome_receita = $_POST['nomereceita'];
    $descricao_receita = $_POST['descricao'];
    $tempo_receita = $_POST['tempo'];
    $dificuldade_receita = $_POST['dificuldade'];
    $imagem_receita = $_POST['imagem'];
    $ingredientes_receita = $_POST['ingredientes'];
    $tipo_receita = $_POST['tipo'];

    if ($_POST["adicionar"] == "Adicionar") {
        $receitas = get_option("receitas");
        $nova_receita = array(["nomereceita" => $nome_receita, "descricao" => $descricao_receita, "tempo" => $tempo_receita, "dificuldade" => $dificuldade_receita, "imagem" => $imagem_receita, "ingredientes" => $ingredientes_receita, "tipo" => $tipo_receita]);
        array_push($receitas,$nova_receita);
        update_option("receitas", $receitas);
    }
    if ($_POST["editar"] == "Editar") {
        $receitas = get_option("receitas");
        $editar_receita = array(["nomereceita" => $nome_receita, "descricao" => $descricao_receita, "tempo" => $tempo_receita, "dificuldade" => $dificuldade_receita, "imagem" => $imagem_receita, "ingredientes" => $ingredientes_receita, "tipo" => $tipo_receita]);
        $receitas[$id] = $editar_receita;
        update_option("receitas", $receitas);
    }
   echo "Gravado com sucesso";


    return "ok";
}

function editar(){
    ?>
    <h1 align="center">Editar Receita Existente</h1>
    <table border="2">
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Descrição</th>
        <th>Tempo</th>
        <th>Dificuldade</th>
        <th>Imagem</th>
        <th>Ingredientes</th>
        <th>Tipo</th>
        <th>Ação</th>
    </tr>
    <?php foreach (get_option("receitas") as $indice => $dados) { ?>
        <?php foreach ($dados as $dado) { ?>
        <tr>
            <td><?= $indice ?></td>
            <td><?= $dado["nomereceita"] ?></td>
            <td><?= $dado["descricao"] ?></td>
            <td><?= $dado["tempo"] ?></td>
            <td><?= $dado["dificuldade"] ?></td>
            <td><?= $dado["imagem"] ?></td>
            <td><?= $dado["ingredientes"] ?></td>
            <td><?= $dado["tipo"] ?></td>
            <td><a href="admin.php?page=editar_receita&id=<?= $indice ?>">Editar</a></td>
            </td>
        </tr>
        <?php
        }
    }
}

function editar_receita(){
    $id = $_GET["id"];
    $dados = get_option("receitas");
    $dado =  $dados[$id];
    ?>
    <hr/>
    <h1 align="center">Editar Receita Existente</h1>
    <br>
    <form action="admin.php?page=salvar_receita" method="POST">
        <label for="nomereceita">Nome da Receita:</label>
        <input type="text" name="nomereceita" id="nomereceita" value="<?= $dado["nomereceita"] ?>"/><br/>
        <label for="descricao"><br/>Descrição: </label>
        <textarea rows="10" cols="100" name="descricao" id="descricao"><?= $dado["descricao"] ?></textarea><br/>
        <label for="tempo">Tempo de preparo: </label>
        <input type="hidden" name="id" id="id" value="<?= $id ?>"/><br/>
        <input type="text" name="tempo" id="tempo" value="<?= $dado["tempo"] ?>"/><br/>
        <label for="dificuldade">Dificuldade da receita: </label><br/>
        <input type="checkbox" name="dificuldade" id="dificuldade" value="facil"/>Fácil<br/>
        <input type="checkbox" name="dificuldade" id="dificuldade" value="medio"/>Médio<br/>
        <input type="checkbox" name="dificuldade" id="dificuldade" value="dificil"/>Dificil<br/>
        <label for="imagem">Imagem da Receita (coloque a URL completa): </label>
        <input type="text" name="imagem" id="imagem" value="<?= $dado["imagem"] ?>"/><br/>
        <label for="ingredientes">Ingredientes: </label>
        <textarea rows="10" cols="100" name="ingredientes"
                  id="ingredientes"><?= $dado["ingredientes"] ?></textarea><br/>
        <label for="tipo">Tipo de Receita: </label><br/>
        <input type="radio" name="tipo" id="tipo" value="doce"/>Doce<br/>
        <input type="radio" name="tipo" id="tipo" value="salgado"/>Salgado<br/><br/>
        <input type="submit" name="editar" value="Editar">
    </form>
    <?php
}

function deletar_receita(){
    $id = $_GET["id"];
    $dados = get_option("receitas");
    unset($dados[$id]);
    update_option("receitas",$dados);
    echo "Deletado com sucesso";

    return "ok";
}

function deletar(){
    ?>
    <h1 align="center">Deletar Receita Existente</h1>
    <table border="2">
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Descrição</th>
        <th>Tempo</th>
        <th>Dificuldade</th>
        <th>Imagem</th>
        <th>Ingredientes</th>
        <th>Tipo</th>
        <th>Ação</th>
    </tr>
    <?php foreach (get_option("receitas") as $indice => $dados) { ?>
        <?php foreach ($dados as $dado) { ?>
    <tr>
        <td><?= $indice ?></td>
        <td><?= $dado["nomereceita"] ?></td>
        <td><?= $dado["descricao"] ?></td>
        <td><?= $dado["tempo"] ?></td>
        <td><?= $dado["dificuldade"] ?></td>
        <td><?= $dado["imagem"] ?></td>
        <td><?= $dado["ingredientes"] ?></td>
        <td><?= $dado["tipo"] ?></td>
        <td><a href="admin.php?page=deletar_receita&id=<?= $indice ?>">Deletar</a></td>
        </td>
    </tr>
    <?php
        }
    }
}

