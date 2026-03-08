<?php include 'app/views/layout/header.php'; ?>

<div class="container mt-4">

<h4>🦷 Odontograma</h4>

<!-- ===================== -->
<!-- DENTIÇÃO PERMANENTE -->
<!-- ===================== -->

<div class="odontograma">

<h5 class="mt-4">Dentição Permanente</h5>

<div class="linha-dentes">

<button class="dente" onclick="abrirDente(18)">
<span>18</span>
<?php
    $registro = $prontuario->buscarRegistroDente($paciente["id"],18);
    if($registro){
    $proc = $registro["procedimento"];
?>
<div class="proc-layer">
    <div class="proc-item"
        style="background-image:url('<?= BASE_URL ?>public/assets/odontograma/<?= $proc ?>.png')">
    </div>
</div>
<?php } ?>
</button>

<button class="dente" onclick="abrirDente(17)">
<span>17</span>
<?php
    $registro = $prontuario->buscarRegistroDente($paciente["id"],17);
    if($registro){
    $proc = $registro["procedimento"];
?>
<div class="proc-layer">
    <div class="proc-item"
        style="background-image:url('<?= BASE_URL ?>public/assets/odontograma/<?= $proc ?>.png')">
    </div>
</div>
<?php } ?>
</button>

<button class="dente" onclick="abrirDente(16)">
<span>16</span>
<?php
    $registro = $prontuario->buscarRegistroDente($paciente["id"],16);
    if($registro){
    $proc = $registro["procedimento"];
?>
<div class="proc-layer">
    <div class="proc-item"
        style="background-image:url('<?= BASE_URL ?>public/assets/odontograma/<?= $proc ?>.png')">
    </div>
</div>
<?php } ?>
</button>

<button class="dente" onclick="abrirDente(15)">
<span>15</span>
<?php
    $registro = $prontuario->buscarRegistroDente($paciente["id"],15);
    if($registro){
    $proc = $registro["procedimento"];
?>
<div class="proc-layer">
    <div class="proc-item"
        style="background-image:url('<?= BASE_URL ?>public/assets/odontograma/<?= $proc ?>.png')">
    </div>
</div>
<?php } ?>
</button>

<button class="dente" onclick="abrirDente(14)">
<span>14</span>
<?php
    $registro = $prontuario->buscarRegistroDente($paciente["id"],14);
    if($registro){
    $proc = $registro["procedimento"];
?>
<div class="proc-layer">
    <div class="proc-item"
        style="background-image:url('<?= BASE_URL ?>public/assets/odontograma/<?= $proc ?>.png')">
    </div>
</div>
<?php } ?>
</button>

<button class="dente" onclick="abrirDente(13)">
<span>13</span>
<?php
    $registro = $prontuario->buscarRegistroDente($paciente["id"],13);
    if($registro){
    $proc = $registro["procedimento"];
?>
<div class="proc-layer">
    <div class="proc-item"
        style="background-image:url('<?= BASE_URL ?>public/assets/odontograma/<?= $proc ?>.png')">
    </div>
</div>
<?php } ?>
</button>

<button class="dente" onclick="abrirDente(12)">
<span>12</span>
<?php
    $registro = $prontuario->buscarRegistroDente($paciente["id"],12);
    if($registro){
    $proc = $registro["procedimento"];
?>
<div class="proc-layer">
    <div class="proc-item"
        style="background-image:url('<?= BASE_URL ?>public/assets/odontograma/<?= $proc ?>.png')">
    </div>
</div>
<?php } ?>
</button>

<button class="dente" onclick="abrirDente(11)">
<span>11</span>
<?php
    $registro = $prontuario->buscarRegistroDente($paciente["id"],11);
    if($registro){
    $proc = $registro["procedimento"];
?>
<div class="proc-layer">
    <div class="proc-item"
        style="background-image:url('<?= BASE_URL ?>public/assets/odontograma/<?= $proc ?>.png')">
    </div>
</div>
<?php } ?>
</button>

<span class="quadrante-gap"></span>

<button class="dente" onclick="abrirDente(21)">
<span>21</span>
<?php
    $registro = $prontuario->buscarRegistroDente($paciente["id"],21);
    if($registro){
    $proc = $registro["procedimento"];
?>
<div class="proc-layer">
    <div class="proc-item"
        style="background-image:url('<?= BASE_URL ?>public/assets/odontograma/<?= $proc ?>.png')">
    </div>
</div>
<?php } ?>
</button>

<button class="dente" onclick="abrirDente(22)">
<span>22</span>
<?php
    $registro = $prontuario->buscarRegistroDente($paciente["id"],22);
    if($registro){
    $proc = $registro["procedimento"];
?>
<div class="proc-layer">
    <div class="proc-item"
        style="background-image:url('<?= BASE_URL ?>public/assets/odontograma/<?= $proc ?>.png')">
    </div>
</div>
<?php } ?>
</button>

<button class="dente" onclick="abrirDente(23)">
<span>23</span>
<?php
    $registro = $prontuario->buscarRegistroDente($paciente["id"],23);
    if($registro){
    $proc = $registro["procedimento"];
?>
<div class="proc-layer">
    <div class="proc-item"
        style="background-image:url('<?= BASE_URL ?>public/assets/odontograma/<?= $proc ?>.png')">
    </div>
</div>
<?php } ?>
</button>

<button class="dente" onclick="abrirDente(24)">
<span>24</span>
<?php
    $registro = $prontuario->buscarRegistroDente($paciente["id"],24);
    if($registro){
    $proc = $registro["procedimento"];
?>
<div class="proc-layer">
    <div class="proc-item"
        style="background-image:url('<?= BASE_URL ?>public/assets/odontograma/<?= $proc ?>.png')">
    </div>
</div>
<?php } ?>
</button>

<button class="dente" onclick="abrirDente(25)">
<span>25</span>
<?php
    $registro = $prontuario->buscarRegistroDente($paciente["id"],25);
    if($registro){
    $proc = $registro["procedimento"];
?>
<div class="proc-layer">
    <div class="proc-item"
        style="background-image:url('<?= BASE_URL ?>public/assets/odontograma/<?= $proc ?>.png')">
    </div>
</div>
<?php } ?>
</button>

<button class="dente" onclick="abrirDente(26)">
<span>26</span>
<?php
    $registro = $prontuario->buscarRegistroDente($paciente["id"],26);
    if($registro){
    $proc = $registro["procedimento"];
?>
<div class="proc-layer">
    <div class="proc-item"
        style="background-image:url('<?= BASE_URL ?>public/assets/odontograma/<?= $proc ?>.png')">
    </div>
</div>
<?php } ?>
</button>

<button class="dente" onclick="abrirDente(27)">
<span>27</span>
<?php
    $registro = $prontuario->buscarRegistroDente($paciente["id"],27);
    if($registro){
    $proc = $registro["procedimento"];
?>
<div class="proc-layer">
    <div class="proc-item"
        style="background-image:url('<?= BASE_URL ?>public/assets/odontograma/<?= $proc ?>.png')">
    </div>
</div>
<?php } ?>
</button>

<button class="dente" onclick="abrirDente(28)">
<span>28</span>
<?php
    $registro = $prontuario->buscarRegistroDente($paciente["id"],28);
    if($registro){
    $proc = $registro["procedimento"];
?>
<div class="proc-layer">
    <div class="proc-item"
        style="background-image:url('<?= BASE_URL ?>public/assets/odontograma/<?= $proc ?>.png')">
    </div>
</div>
<?php } ?>
</button>

</div>

<div class="linha-dentes">

<button class="dente" onclick="abrirDente(48)">
<span>48</span>
<?php
    $registro = $prontuario->buscarRegistroDente($paciente["id"],48);
    if($registro){
    $proc = $registro["procedimento"];
?>
<div class="proc-layer">
    <div class="proc-item"
        style="background-image:url('<?= BASE_URL ?>public/assets/odontograma/<?= $proc ?>.png')">
    </div>
</div>
<?php } ?>
</button>

<button class="dente" onclick="abrirDente(47)">
<span>47</span>
<?php
    $registro = $prontuario->buscarRegistroDente($paciente["id"],47);
    if($registro){
    $proc = $registro["procedimento"];
?>
<div class="proc-layer">
    <div class="proc-item"
        style="background-image:url('<?= BASE_URL ?>public/assets/odontograma/<?= $proc ?>.png')">
    </div>
</div>
<?php } ?>
</button>

<button class="dente" onclick="abrirDente(46)">
<span>46</span>
<?php
    $registro = $prontuario->buscarRegistroDente($paciente["id"],46);
    if($registro){
    $proc = $registro["procedimento"];
?>
<div class="proc-layer">
    <div class="proc-item"
        style="background-image:url('<?= BASE_URL ?>public/assets/odontograma/<?= $proc ?>.png')">
    </div>
</div>
<?php } ?>
</button>

<button class="dente" onclick="abrirDente(45)">
<span>45</span>
<?php
    $registro = $prontuario->buscarRegistroDente($paciente["id"],45);
    if($registro){
    $proc = $registro["procedimento"];
?>
<div class="proc-layer">
    <div class="proc-item"
        style="background-image:url('<?= BASE_URL ?>public/assets/odontograma/<?= $proc ?>.png')">
    </div>
</div>
<?php } ?>
</button>

<button class="dente" onclick="abrirDente(44)">
<span>44</span>
<?php
    $registro = $prontuario->buscarRegistroDente($paciente["id"],44);
    if($registro){
    $proc = $registro["procedimento"];
?>
<div class="proc-layer">
    <div class="proc-item"
        style="background-image:url('<?= BASE_URL ?>public/assets/odontograma/<?= $proc ?>.png')">
    </div>
</div>
<?php } ?>
</button>

<button class="dente" onclick="abrirDente(43)">
<span>43</span>
<?php
    $registro = $prontuario->buscarRegistroDente($paciente["id"],43);
    if($registro){
    $proc = $registro["procedimento"];
?>
<div class="proc-layer">
    <div class="proc-item"
        style="background-image:url('<?= BASE_URL ?>public/assets/odontograma/<?= $proc ?>.png')">
    </div>
</div>
<?php } ?>
</button>

<button class="dente" onclick="abrirDente(42)">
<span>42</span>
<?php
    $registro = $prontuario->buscarRegistroDente($paciente["id"],42);
    if($registro){
    $proc = $registro["procedimento"];
?>
<div class="proc-layer">
    <div class="proc-item"
        style="background-image:url('<?= BASE_URL ?>public/assets/odontograma/<?= $proc ?>.png')">
    </div>
</div>
<?php } ?>
</button>

<button class="dente" onclick="abrirDente(41)">
<span>41</span>
<?php
    $registro = $prontuario->buscarRegistroDente($paciente["id"],41);
    if($registro){
    $proc = $registro["procedimento"];
?>
<div class="proc-layer">
    <div class="proc-item"
        style="background-image:url('<?= BASE_URL ?>public/assets/odontograma/<?= $proc ?>.png')">
    </div>
</div>
<?php } ?>
</button>

<span class="quadrante-gap"></span>

<button class="dente" onclick="abrirDente(31)">
<span>31</span>
<?php
    $registro = $prontuario->buscarRegistroDente($paciente["id"],31);
    if($registro){
    $proc = $registro["procedimento"];
?>
<div class="proc-layer">
    <div class="proc-item"
        style="background-image:url('<?= BASE_URL ?>public/assets/odontograma/<?= $proc ?>.png')">
    </div>
</div>
<?php } ?>
</button>

<button class="dente" onclick="abrirDente(32)">
<span>32</span>
<?php
    $registro = $prontuario->buscarRegistroDente($paciente["id"],32);
    if($registro){
    $proc = $registro["procedimento"];
?>
<div class="proc-layer">
    <div class="proc-item"
        style="background-image:url('<?= BASE_URL ?>public/assets/odontograma/<?= $proc ?>.png')">
    </div>
</div>
<?php } ?>
</button>

<button class="dente" onclick="abrirDente(33)">
<span>33</span>
<?php
    $registro = $prontuario->buscarRegistroDente($paciente["id"],33);
    if($registro){
    $proc = $registro["procedimento"];
?>
<div class="proc-layer">
    <div class="proc-item"
        style="background-image:url('<?= BASE_URL ?>public/assets/odontograma/<?= $proc ?>.png')">
    </div>
</div>
<?php } ?>
</button>

<button class="dente" onclick="abrirDente(34)">
<span>34</span>
<?php
    $registro = $prontuario->buscarRegistroDente($paciente["id"],34);
    if($registro){
    $proc = $registro["procedimento"];
?>
<div class="proc-layer">
    <div class="proc-item"
        style="background-image:url('<?= BASE_URL ?>public/assets/odontograma/<?= $proc ?>.png')">
    </div>
</div>
<?php } ?>
</button>

<button class="dente" onclick="abrirDente(35)">
<span>35</span>
<?php
    $registro = $prontuario->buscarRegistroDente($paciente["id"],35);
    if($registro){
    $proc = $registro["procedimento"];
?>
<div class="proc-layer">
    <div class="proc-item"
        style="background-image:url('<?= BASE_URL ?>public/assets/odontograma/<?= $proc ?>.png')">
    </div>
</div>
<?php } ?>
</button>

<button class="dente" onclick="abrirDente(36)">
<span>36</span>
<?php
    $registro = $prontuario->buscarRegistroDente($paciente["id"],36);
    if($registro){
    $proc = $registro["procedimento"];
?>
<div class="proc-layer">
    <div class="proc-item"
        style="background-image:url('<?= BASE_URL ?>public/assets/odontograma/<?= $proc ?>.png')">
    </div>
</div>
<?php } ?>
</button>

<button class="dente" onclick="abrirDente(37)">
<span>37</span>
<?php
    $registro = $prontuario->buscarRegistroDente($paciente["id"],37);
    if($registro){
    $proc = $registro["procedimento"];
?>
<div class="proc-layer">
    <div class="proc-item"
        style="background-image:url('<?= BASE_URL ?>public/assets/odontograma/<?= $proc ?>.png')">
    </div>
</div>
<?php } ?>
</button>

<button class="dente" onclick="abrirDente(38)">
<span>38</span>
<?php
    $registro = $prontuario->buscarRegistroDente($paciente["id"],38);
    if($registro){
    $proc = $registro["procedimento"];
?>
<div class="proc-layer">
    <div class="proc-item"
        style="background-image:url('<?= BASE_URL ?>public/assets/odontograma/<?= $proc ?>.png')">
    </div>
</div>
<?php } ?>
</button>

</div>

</div>


<!-- ===================== -->
<!-- DENTIÇÃO DECÍDUA -->
<!-- ===================== -->

<div class="odontograma deciduos deciduo-container">

<h5 class="mt-5">Dentição Decídua</h5>

<div class="linha-dentes">

<button class="dente" onclick="abrirDente(55)">
<span>55</span>
<?php
    $registro = $prontuario->buscarRegistroDente($paciente["id"],55);
    if($registro){
    $proc = $registro["procedimento"];
?>
<div class="proc-layer">
    <div class="proc-item"
        style="background-image:url('<?= BASE_URL ?>public/assets/odontograma/<?= $proc ?>.png')">
    </div>
</div>
<?php } ?>
</button>

<button class="dente" onclick="abrirDente(54)">
<span>54</span>
<?php
    $registro = $prontuario->buscarRegistroDente($paciente["id"],54);
    if($registro){
    $proc = $registro["procedimento"];
?>
<div class="proc-layer">
    <div class="proc-item"
        style="background-image:url('<?= BASE_URL ?>public/assets/odontograma/<?= $proc ?>.png')">
    </div>
</div>
<?php } ?>
</button>

<button class="dente" onclick="abrirDente(53)">
<span>53</span>
<?php
    $registro = $prontuario->buscarRegistroDente($paciente["id"],53);
    if($registro){
    $proc = $registro["procedimento"];
?>
<div class="proc-layer">
    <div class="proc-item"
        style="background-image:url('<?= BASE_URL ?>public/assets/odontograma/<?= $proc ?>.png')">
    </div>
</div>
<?php } ?>
</button>
>
<button class="dente" onclick="abrirDente(52)">
<span>52</span>
<?php
    $registro = $prontuario->buscarRegistroDente($paciente["id"],52);
    if($registro){
    $proc = $registro["procedimento"];
?>
<div class="proc-layer">
    <div class="proc-item"
        style="background-image:url('<?= BASE_URL ?>public/assets/odontograma/<?= $proc ?>.png')">
    </div>
</div>
<?php } ?>
</button>

<button class="dente" onclick="abrirDente(51)">
<span>51</span>
<?php
    $registro = $prontuario->buscarRegistroDente($paciente["id"],51);
    if($registro){
    $proc = $registro["procedimento"];
?>
<div class="proc-layer">
    <div class="proc-item"
        style="background-image:url('<?= BASE_URL ?>public/assets/odontograma/<?= $proc ?>.png')">
    </div>
</div>
<?php } ?>
</button>

<span class="quadrante-gap"></span>

<button class="dente" onclick="abrirDente(61)">
<span>61</span>
<?php
    $registro = $prontuario->buscarRegistroDente($paciente["id"],61);
    if($registro){
    $proc = $registro["procedimento"];
?>
<div class="proc-layer">
    <div class="proc-item"
        style="background-image:url('<?= BASE_URL ?>public/assets/odontograma/<?= $proc ?>.png')">
    </div>
</div>
<?php } ?>
</button>

<button class="dente" onclick="abrirDente(62)">
<span>62</span>
<?php
    $registro = $prontuario->buscarRegistroDente($paciente["id"],62);
    if($registro){
    $proc = $registro["procedimento"];
?>
<div class="proc-layer">
    <div class="proc-item"
        style="background-image:url('<?= BASE_URL ?>public/assets/odontograma/<?= $proc ?>.png')">
    </div>
</div>
<?php } ?>
</button>

<button class="dente" onclick="abrirDente(63)">
<span>63</span>
<?php
    $registro = $prontuario->buscarRegistroDente($paciente["id"],63);
    if($registro){
    $proc = $registro["procedimento"];
?>
<div class="proc-layer">
    <div class="proc-item"
        style="background-image:url('<?= BASE_URL ?>public/assets/odontograma/<?= $proc ?>.png')">
    </div>
</div>
<?php } ?>
</button>

<button class="dente" onclick="abrirDente(64)">
<span>64</span>
<?php
    $registro = $prontuario->buscarRegistroDente($paciente["id"],64);
    if($registro){
    $proc = $registro["procedimento"];
?>
<div class="proc-layer">
    <div class="proc-item"
        style="background-image:url('<?= BASE_URL ?>public/assets/odontograma/<?= $proc ?>.png')">
    </div>
</div>
<?php } ?>
</button>

<button class="dente" onclick="abrirDente(65)">
<span>65</span>
<?php
    $registro = $prontuario->buscarRegistroDente($paciente["id"],65);
    if($registro){
    $proc = $registro["procedimento"];
?>
<div class="proc-layer">
    <div class="proc-item"
        style="background-image:url('<?= BASE_URL ?>public/assets/odontograma/<?= $proc ?>.png')">
    </div>
</div>
<?php } ?>
</button>

</div>

<div class="linha-dentes">

<button class="dente" onclick="abrirDente(85)">
<span>85</span>
<?php
    $registro = $prontuario->buscarRegistroDente($paciente["id"],85);
    if($registro){
    $proc = $registro["procedimento"];
?>
<div class="proc-layer">
    <div class="proc-item"
        style="background-image:url('<?= BASE_URL ?>public/assets/odontograma/<?= $proc ?>.png')">
    </div>
</div>
<?php } ?>
</button>

<button class="dente" onclick="abrirDente(84)">
<span>84</span>
<?php
    $registro = $prontuario->buscarRegistroDente($paciente["id"],84);
    if($registro){
    $proc = $registro["procedimento"];
?>
<div class="proc-layer">
    <div class="proc-item"
        style="background-image:url('<?= BASE_URL ?>public/assets/odontograma/<?= $proc ?>.png')">
    </div>
</div>
<?php } ?>
</button>

<button class="dente" onclick="abrirDente(83)">
<span>83</span>
<?php
    $registro = $prontuario->buscarRegistroDente($paciente["id"],83);
    if($registro){
    $proc = $registro["procedimento"];
?>
<div class="proc-layer">
    <div class="proc-item"
        style="background-image:url('<?= BASE_URL ?>public/assets/odontograma/<?= $proc ?>.png')">
    </div>
</div>
<?php } ?>
</button>

<button class="dente" onclick="abrirDente(82)">
<span>82</span>
<?php
    $registro = $prontuario->buscarRegistroDente($paciente["id"],82);
    if($registro){
    $proc = $registro["procedimento"];
?>
<div class="proc-layer">
    <div class="proc-item"
        style="background-image:url('<?= BASE_URL ?>public/assets/odontograma/<?= $proc ?>.png')">
    </div>
</div>
<?php } ?>
</button>

<button class="dente" onclick="abrirDente(81)">
<span>81</span>
<?php
    $registro = $prontuario->buscarRegistroDente($paciente["id"],81);
    if($registro){
    $proc = $registro["procedimento"];
?>
<div class="proc-layer">
    <div class="proc-item"
        style="background-image:url('<?= BASE_URL ?>public/assets/odontograma/<?= $proc ?>.png')">
    </div>
</div>
<?php } ?>
</button>

<span class="quadrante-gap"></span>

<button class="dente" onclick="abrirDente(71)">
<span>71</span>
<?php
    $registro = $prontuario->buscarRegistroDente($paciente["id"],71);
    if($registro){
    $proc = $registro["procedimento"];
?>
<div class="proc-layer">
    <div class="proc-item"
        style="background-image:url('<?= BASE_URL ?>public/assets/odontograma/<?= $proc ?>.png')">
    </div>
</div>
<?php } ?>
</button>

<button class="dente" onclick="abrirDente(72)">
<span>72</span>
<?php
    $registro = $prontuario->buscarRegistroDente($paciente["id"],72);
    if($registro){
    $proc = $registro["procedimento"];
?>
<div class="proc-layer">
    <div class="proc-item"
        style="background-image:url('<?= BASE_URL ?>public/assets/odontograma/<?= $proc ?>.png')">
    </div>
</div>
<?php } ?>
</button>

<button class="dente" onclick="abrirDente(73)">
<span>73</span>
<?php
    $registro = $prontuario->buscarRegistroDente($paciente["id"],73);
    if($registro){
    $proc = $registro["procedimento"];
?>
<div class="proc-layer">
    <div class="proc-item"
        style="background-image:url('<?= BASE_URL ?>public/assets/odontograma/<?= $proc ?>.png')">
    </div>
</div>
<?php } ?>
</button>

<button class="dente" onclick="abrirDente(74)">
<span>74</span>
<?php
    $registro = $prontuario->buscarRegistroDente($paciente["id"],74);
    if($registro){
    $proc = $registro["procedimento"];
?>
<div class="proc-layer">
    <div class="proc-item"
        style="background-image:url('<?= BASE_URL ?>public/assets/odontograma/<?= $proc ?>.png')">
    </div>
</div>
<?php } ?>
</button>

<button class="dente" onclick="abrirDente(75)">
<span>75</span>
<?php
    $registro = $prontuario->buscarRegistroDente($paciente["id"],75);
    if($registro){
    $proc = $registro["procedimento"];
?>
<div class="proc-layer">
    <div class="proc-item"
        style="background-image:url('<?= BASE_URL ?>public/assets/odontograma/<?= $proc ?>.png')">
    </div>
</div>
<?php } ?>
</button>

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

<form method="POST" action="<?= BASE_URL ?>prontuarios/salvarRegistro">

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