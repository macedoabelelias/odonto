<?php include 'app/views/layout/header.php'; ?>

<div class="container mt-4">

<h4>🦷 Odontograma</h4>

<!-- ===================== -->
<!-- DENTIÇÃO PERMANENTE -->
<!-- ===================== -->

<div class="odontograma">

<h5 class="mt-4">Dentição Permanente</h5>

<div class="linha-dentes">

<button class="dente" onclick="abrirDente(18)">18</button>
<button class="dente" onclick="abrirDente(17)">17</button>
<button class="dente" onclick="abrirDente(16)">16</button>
<button class="dente" onclick="abrirDente(15)">15</button>
<button class="dente" onclick="abrirDente(14)">14</button>
<button class="dente" onclick="abrirDente(13)">13</button>
<button class="dente" onclick="abrirDente(12)">12</button>
<button class="dente" onclick="abrirDente(11)">11</button>

<span class="quadrante-gap"></span>

<button class="dente" onclick="abrirDente(21)">21</button>
<button class="dente" onclick="abrirDente(22)">22</button>
<button class="dente" onclick="abrirDente(23)">23</button>
<button class="dente" onclick="abrirDente(24)">24</button>
<button class="dente" onclick="abrirDente(25)">25</button>
<button class="dente" onclick="abrirDente(26)">26</button>
<button class="dente" onclick="abrirDente(27)">27</button>
<button class="dente" onclick="abrirDente(28)">28</button>

</div>

<div class="linha-dentes">

<button class="dente" onclick="abrirDente(48)">48</button>
<button class="dente" onclick="abrirDente(47)">47</button>
<button class="dente" onclick="abrirDente(46)">46</button>
<button class="dente" onclick="abrirDente(45)">45</button>
<button class="dente" onclick="abrirDente(44)">44</button>
<button class="dente" onclick="abrirDente(43)">43</button>
<button class="dente" onclick="abrirDente(42)">42</button>
<button class="dente" onclick="abrirDente(41)">41</button>

<span class="quadrante-gap"></span>

<button class="dente" onclick="abrirDente(31)">31</button>
<button class="dente" onclick="abrirDente(32)">32</button>
<button class="dente" onclick="abrirDente(33)">33</button>
<button class="dente" onclick="abrirDente(34)">34</button>
<button class="dente" onclick="abrirDente(35)">35</button>
<button class="dente" onclick="abrirDente(36)">36</button>
<button class="dente" onclick="abrirDente(37)">37</button>
<button class="dente" onclick="abrirDente(38)">38</button>

</div>

</div>


<!-- ===================== -->
<!-- DENTIÇÃO DECÍDUA -->
<!-- ===================== -->

<div class="odontograma deciduos">

<h5 class="mt-5">Dentição Decídua</h5>

<div class="linha-dentes">

<button class="dente" onclick="abrirDente(55)">55</button>
<button class="dente" onclick="abrirDente(54)">54</button>
<button class="dente" onclick="abrirDente(53)">53</button>
<button class="dente" onclick="abrirDente(52)">52</button>
<button class="dente" onclick="abrirDente(51)">51</button>

<span class="quadrante-gap"></span>

<button class="dente" onclick="abrirDente(61)">61</button>
<button class="dente" onclick="abrirDente(62)">62</button>
<button class="dente" onclick="abrirDente(63)">63</button>
<button class="dente" onclick="abrirDente(64)">64</button>
<button class="dente" onclick="abrirDente(65)">65</button>

</div>

<div class="linha-dentes">

<button class="dente" onclick="abrirDente(85)">85</button>
<button class="dente" onclick="abrirDente(84)">84</button>
<button class="dente" onclick="abrirDente(83)">83</button>
<button class="dente" onclick="abrirDente(82)">82</button>
<button class="dente" onclick="abrirDente(81)">81</button>

<span class="quadrante-gap"></span>

<button class="dente" onclick="abrirDente(71)">71</button>
<button class="dente" onclick="abrirDente(72)">72</button>
<button class="dente" onclick="abrirDente(73)">73</button>
<button class="dente" onclick="abrirDente(74)">74</button>
<button class="dente" onclick="abrirDente(75)">75</button>

</div>

</div>

</div>


<!-- ===================== -->
<!-- MODAL PROCEDIMENTO -->
<!-- ===================== -->

<div class="modal fade" id="modalProcedimento">

<div class="modal-dialog">
<div class="modal-content">

<div class="modal-header">
<h5>Procedimento no Dente</h5>
<button class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<form method="POST" action="<?= BASE_URL ?>prontuario/salvarRegistro">

<input type="hidden" name="paciente_id" value="<?= $paciente['id'] ?>">
<input type="hidden" name="dente" id="denteSelecionado">

<label>Procedimento</label>

<select name="procedimento" class="form-control">

<option value="carie">Cárie</option>
<option value="restauracao">Restauração</option>
<option value="canal">Canal</option>
<option value="coroa">Coroa</option>
<option value="implante">Implante</option>
<option value="profilaxia">Profilaxia</option>
<option value="raspagem">Raspagem</option>
<option value="cirurgia">Cirurgia</option>

</select>

<label class="mt-3">Status</label>

<select name="status" class="form-control">

<option value="a_realizar">A realizar</option>
<option value="realizado">Realizado</option>

</select>

<label class="mt-3">Observações</label>

<textarea name="observacoes" class="form-control"></textarea>

<button class="btn btn-primary mt-3">
Salvar
</button>

</form>

</div>

</div>
</div>
</div>


<script>

function abrirDente(numero){

document.getElementById("denteSelecionado").value = numero;

var modal = new bootstrap.Modal(
document.getElementById("modalProcedimento")
);

modal.show();

}

</script>

<?php include 'app/views/layout/footer.php'; ?>