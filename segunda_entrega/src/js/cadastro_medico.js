document.addEventListener("DOMContentLoaded", function() {
    // Simular informações do usuário
    // document.getElementById("user-info").innerHTML = "<i class=\"fas fa-user\"></i> João Silva (Admin)";

    const crmInput = document.getElementById('crm');
    if (crmInput) {
        aplicarMascaraCRM(crmInput);
    }
});

// Função de logout (simulada)
const VitaCare = {
    logout: function() {
        window.location.href = "../public/login.html";
    }
};