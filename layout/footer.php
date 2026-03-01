    </div> <!-- content -->
</div> <!-- main -->

</div> <!-- wrapper -->

<script>
document.addEventListener("DOMContentLoaded", function(){

    const btn = document.getElementById("btnConfig");
    const menu = document.getElementById("menuConfig");

    if(btn){
        btn.addEventListener("click", function(e){
            e.stopPropagation();
            menu.style.display = (menu.style.display === "flex") ? "none" : "flex";
        });

        document.addEventListener("click", function(){
            menu.style.display = "none";
        });
    }

});
</script>

<script>

document.addEventListener("DOMContentLoaded", function(){

    document.querySelectorAll("#telefone, #whatsapp, #resp_tel").forEach(function(campo){
        mascaraTelefone(campo);
    });

});
</script>

</div> <!-- page-wrapper -->



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>



</body>
</html>