<h4>Gerar Receita</h4>

<div class="alert alert-info">

Paciente: <strong><?= $paciente['nome'] ?></strong>

</div>


<form method="POST" action="<?= BASE_URL ?>/documentos/receita/<?= $paciente['id'] ?>">

<div class="mb-3">
<label class="form-label">Medicamento</label>

<select name="medicamento" id="medicamento" class="form-control" required>
<option value="">Selecione o medicamento</option>

<option value="Amoxicilina 500mg">Amoxicilina 500mg</option>
<option value="Amoxicilina + Clavulanato 875mg">Amoxicilina + Clavulanato 875mg</option>
<option value="Azitromicina 500mg">Azitromicina 500mg</option>
<option value="Clindamicina 300mg">Clindamicina 300mg</option>

<option value="Ibuprofeno 600mg">Ibuprofeno 600mg</option>
<option value="Nimesulida 100mg">Nimesulida 100mg</option>
<option value="Paracetamol 750mg">Paracetamol 750mg</option>
<option value="Dipirona 500mg">Dipirona 500mg</option>

<option value="Diclofenaco Sódico 50mg">Diclofenaco Sódico 50mg</option>
<option value="Cetoprofeno 100mg">Cetoprofeno 100mg</option>

<option value="Dexametasona 4mg">Dexametasona 4mg</option>
<option value="Prednisona 20mg">Prednisona 20mg</option>

<option value="Metronidazol 400mg">Metronidazol 400mg</option>

<option value="Clorexidina 0,12%">Clorexidina 0,12%</option>
</select>
</div>


<div class="mb-3">
<label class="form-label">Posologia</label>

<input
type="text"
name="posologia"
id="posologia"
class="form-control">
</div>


<div class="mb-3">
<label class="form-label">Duração do tratamento</label>

<input
type="text"
name="duracao"
id="duracao"
class="form-control">
</div>


<div class="mb-3">

<label class="form-label">Observações</label>

<textarea
name="observacao"
class="form-control"
rows="3"></textarea>

</div>


<button class="btn btn-success">

Gerar Receita

</button>

</form>

<script>

const medicamentos = {

"Amoxicilina 500mg": {
posologia: "1 cápsula a cada 8 horas",
duracao: "7 dias"
},

"Amoxicilina + Clavulanato 875mg": {
posologia: "1 comprimido a cada 12 horas",
duracao: "7 dias"
},

"Azitromicina 500mg": {
posologia: "1 comprimido ao dia",
duracao: "3 dias"
},

"Clindamicina 300mg": {
posologia: "1 cápsula a cada 6 horas",
duracao: "7 dias"
},

"Ibuprofeno 600mg": {
posologia: "1 comprimido a cada 8 horas",
duracao: "3 a 5 dias"
},

"Nimesulida 100mg": {
posologia: "1 comprimido a cada 12 horas",
duracao: "3 dias"
},

"Paracetamol 750mg": {
posologia: "1 comprimido a cada 6 horas se dor",
duracao: "3 dias"
},

"Dipirona 500mg": {
posologia: "1 comprimido a cada 6 horas se dor",
duracao: "3 dias"
},

"Diclofenaco Sódico 50mg": {
posologia: "1 comprimido a cada 8 horas",
duracao: "3 dias"
},

"Cetoprofeno 100mg": {
posologia: "1 comprimido a cada 12 horas",
duracao: "3 dias"
},

"Dexametasona 4mg": {
posologia: "1 comprimido a cada 12 horas",
duracao: "3 dias"
},

"Prednisona 20mg": {
posologia: "1 comprimido ao dia",
duracao: "3 dias"
},

"Metronidazol 400mg": {
posologia: "1 comprimido a cada 8 horas",
duracao: "7 dias"
},

"Clorexidina 0,12%": {
posologia: "Bochechar 15ml por 30 segundos",
duracao: "7 dias"
}

};


document.getElementById("medicamento").addEventListener("change", function(){

let med = this.value;

if(medicamentos[med]){

document.getElementById("posologia").value = medicamentos[med].posologia;
document.getElementById("duracao").value = medicamentos[med].duracao;

}

});

</script>