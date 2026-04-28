<style>
.container-center {
    display: flex;
    justify-content: center;
    margin-top: 40px;
}

.card-nivel {
    width: 420px;
    background: #fff;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.card-nivel h2 {
    margin-bottom: 20px;
    font-size: 22px;
    color: #333;
}

.form-group {
    display: flex;
    flex-direction: column;
    margin-bottom: 15px;
}

.form-group label {
    font-weight: 600;
    margin-bottom: 5px;
    color: #555;
}

.form-group input {
    padding: 10px;
    border-radius: 6px;
    border: 1px solid #ccc;
    transition: 0.2s;
}

.form-group input:focus {
    border-color: #28a745;
    outline: none;
}

.actions {
    display: flex;
    gap: 10px;
    margin-top: 15px;
}

.btn-salvar {
    flex: 1;
    padding: 10px;
    background: #28a745;
    border: none;
    color: #fff;
    border-radius: 6px;
    cursor: pointer;
}

.btn-voltar {
    flex: 1;
    padding: 10px;
    background: #6c757d;
    color: #fff;
    text-align: center;
    border-radius: 6px;
    text-decoration: none;
}
</style>

<div class="container-center">

    <div class="card-nivel">

        <h2>Novo Nível</h2>

        <form method="POST" action="<?= BASE_URL ?>/niveis/salvar">

            <div class="form-group">
                <label>Nome do Nível</label>
                <input type="text" name="nome" placeholder="Ex: Administrador" required>
            </div>

            <div class="form-group">
                <label>Descrição</label>
                <input type="text" name="descricao" placeholder="Opcional">
            </div>

            <div class="actions">
                <button type="submit" class="btn-salvar">Salvar</button>
                <a href="<?= BASE_URL ?>/niveis" class="btn-voltar">Voltar</a>
            </div>

        </form>

    </div>

</div>