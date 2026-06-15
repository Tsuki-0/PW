<style>
    .modal-content {
        border: none;
        border-radius: 14px;
        box-shadow: 0 8px 32px rgba(0,0,0,.12);
        overflow: hidden;
    }

    .modal-header {
        background: #fee2e2;
        border-bottom: 1px solid #fecaca;
        padding: 1.1rem 1.5rem;
    }

    .modal-title {
        font-size: 1rem;
        font-weight: 700;
        color: #991b1b;
        display: flex;
        align-items: center;
        gap: .5rem;
    }

    .modal-body {
        padding: 1.25rem 1.5rem;
        font-size: .9rem;
        color: #374151;
        line-height: 1.6;
    }

    .modal-footer {
        border-top: 1px solid #f3f4f6;
        padding: 1rem 1.5rem;
        display: flex;
        gap: .6rem;
        justify-content: flex-end;
    }

    .modal-btn-confirm {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        background: #dc2626;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: .5rem 1.1rem;
        font-size: .875rem;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        transition: background .15s;
    }

    .modal-btn-confirm:hover { background: #b91c1c; color: #fff; }

    .modal-btn-cancel {
        display: inline-flex;
        align-items: center;
        background: transparent;
        color: #6b7280;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: .5rem 1.1rem;
        font-size: .875rem;
        font-weight: 500;
        cursor: pointer;
        transition: border-color .15s, color .15s;
    }
    .modal-btn-cancel:hover { border-color: #374151; color: #374151; }
</style>

<div class="modal fade" id="excluirModal" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="excluirLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="excluirLabel">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <polyline points="3 6 5 6 21 6"/>
                        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                        <path d="M10 11v6M14 11v6"/>
                        <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                    </svg>
                    Confirmar exclusão
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                Esta ação é <strong>permanente</strong> e não poderá ser desfeita.
                <br>Deseja mesmo excluir este enfermeiro?
            </div>
            <div class="modal-footer">
                <button type="button" class="modal-btn-cancel" data-bs-dismiss="modal">Cancelar</button>
                <a id="confirmar" href="#" class="modal-btn-confirm">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <polyline points="3 6 5 6 21 6"/>
                        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                    </svg>
                    Sim, excluir
                </a>
            </div>
        </div>
    </div>
</div>
