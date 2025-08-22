document.addEventListener("DOMContentLoaded", function() {
            // Simular informações do usuário
    // document.getElementById("user-info").innerHTML = "<i class=\"fas fa-user\"></i> João Silva (Admin)";

    const telefoneInput = document.querySelector('[type="tel"]');
    if (telefoneInput) {
        aplicarMascaraTelefone(telefoneInput);
    }

    const cpfInput = document.getElementById('cpf');
    if (cpfInput) {
        aplicarMascaraCPF(cpfInput);
    }


});

// Função de logout (simulada)
const VitaCare = {
    showToast: function(message, type) {
        const toastEl = document.createElement("div");
        toastEl.className = `toast align-items-center text-bg-${type} border-0`;
        toastEl.role = "alert";
        toastEl.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">${message}</div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>`;
        
        document.body.appendChild(toastEl);
        const toast = new bootstrap.Toast(toastEl);
        toast.show();
        toastEl.addEventListener("hidden.bs.toast", () => toastEl.remove());
    }
};