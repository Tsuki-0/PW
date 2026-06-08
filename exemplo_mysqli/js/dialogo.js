function base64ToUtf8(b64) {
    const binaryString = atob(b64);
    // Create a Uint8Array from the binary string.
    const bytes = new Uint8Array(binaryString.length);
    for (let i = 0; i < binaryString.length; i++) {
        bytes[i] = binaryString.charCodeAt(i);
    }
    const decoder = new TextDecoder();
    return decoder.decode(bytes);
}
const deleteModal = document.getElementById("excluirModal");
// Evento disparado quando o modal começa a ser exibido
deleteModal.addEventListener('show.bs.modal', (event) => {
    // Botão (link com btn) que acionou o modal
    const button = event.relatedTarget;
    // Corpo do modal para colocarmos a mensagem, referenciado pela classe de CSS
    const modalBody = deleteModal.querySelector(".modal-body");
    // Título do modal para colocarmos a mensagem, referenciado pela classe de CSS
    const modalTitle = deleteModal.querySelector(".modal-title");
    // Botão (link com btn) do modal para confirmarmos a exclusão
    const confirmDelete = document.getElementById("confirmar");
    // Extrai o ID do item armazenado no data-contato
    var idParaExcluir = button.getAttribute('data-produto');
    // Usa a função base64ToUtf8() para converter para base64 o ID do produto
    var idParaExibir = base64ToUtf8(button.getAttribute('data-produto'));
    modalTitle.innerHTML = "Apagando Produto: " + idParaExibir;
    modalBody.innerHTML = "Deseja mesmo apagar o produto " + idParaExibir + "?";
    confirmDelete.setAttribute("href", "excluir.php?id=" + idParaExcluir);
});
