    (function() {
        // Controle do dropdown aberto atualmente
        let currentOpenRow = null;
        let currentExtraRow = null;
        
        // Verifica se é mobile (até 768px)
        function isMobile() {
            return window.innerWidth <= 768;
        }
        
        // Cria o elemento do dropdown (os botões)
        function createMobileDropdownContent(id, enfermeiroNome) {
            const dropdownDiv = document.createElement('div');
            dropdownDiv.className = 'mobile-action-dropdown';
            
            // Botão VER
            const btnVer = document.createElement('a');
            btnVer.href = `verenfermeiro.php?id=${id}`;
            btnVer.className = 'btn-act btn-view';
            btnVer.innerHTML = `<svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                                Ver`;
            
            // Botão EDITAR
            const btnEditar = document.createElement('a');
            btnEditar.href = `editar.php?id=${id}`;
            btnEditar.className = 'btn-act btn-edit';
            btnEditar.innerHTML = `<svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                    </svg>
                                    Editar`;
            
            // Botão APAGAR
            const btnApagar = document.createElement('a');
            btnApagar.href = '#';
            btnApagar.className = 'btn-act btn-del';
            btnApagar.setAttribute('data-bs-toggle', 'modal');
            btnApagar.setAttribute('data-bs-target', '#excluirModal');
            btnApagar.setAttribute('data-enfermeiro', id);
            btnApagar.innerHTML = `<svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <polyline points="3 6 5 6 21 6"/>
                                        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                                        <path d="M10 11v6M14 11v6"/>
                                        <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                                    </svg>
                                    Apagar`;
            
            dropdownDiv.appendChild(btnVer);
            dropdownDiv.appendChild(btnEditar);
            dropdownDiv.appendChild(btnApagar);
            
            return dropdownDiv;
        }
        
        // Remove a linha extra de dropdown (se existir)
        function removeDropdownRow() {
            if (currentExtraRow && currentExtraRow.parentNode) {
                // Remove a classe 'dropdown-open' da célula de ações da linha original
                if (currentOpenRow) {
                    const actionsCell = currentOpenRow.querySelector('.actions-cell');
                    if (actionsCell) {
                        actionsCell.classList.remove('dropdown-open');
                    }
                }
                currentExtraRow.remove();
                currentExtraRow = null;
                currentOpenRow = null;
            }
        }
        
        // Fecha o dropdown atual (se existir)
        function closeCurrentDropdown() {
            if (currentExtraRow) {
                const dropdownDiv = currentExtraRow.querySelector('.mobile-action-dropdown');
                if (dropdownDiv) {
                    dropdownDiv.classList.remove('show');
                }
                removeDropdownRow();
            }
        }
        
        // Abre o dropdown abaixo da linha clicada
        function openDropdownBelowRow(row, enfermeiroId, enfermeiroNome) {
            // Fecha qualquer dropdown aberto antes
            closeCurrentDropdown();
            
            // Adiciona a classe 'dropdown-open' na célula de ações
            const actionsCell = row.querySelector('.actions-cell');
            if (actionsCell) {
                actionsCell.classList.add('dropdown-open');
            }
            
            // Cria uma nova linha (tr) para inserir abaixo da linha atual
            const tbody = row.parentNode;
            const newRow = document.createElement('tr');
            newRow.className = 'mobile-dropdown-row';
            
            // Célula que ocupará todas as colunas
            const td = document.createElement('td');
            td.colSpan = 7; // A tabela tem 7 colunas
            td.className = 'mobile-dropdown-cell';
            
            // Cria o conteúdo do dropdown (div com botões)
            const dropdownContent = createMobileDropdownContent(enfermeiroId, enfermeiroNome);
            td.appendChild(dropdownContent);
            newRow.appendChild(td);
            
            // Insere a nova linha após a linha clicada
            if (row.nextSibling) {
                tbody.insertBefore(newRow, row.nextSibling);
            } else {
                tbody.appendChild(newRow);
            }
            
            // Força reflow e mostra o dropdown com animação
            setTimeout(() => {
                dropdownContent.classList.add('show');
            }, 5);
            
            // Armazena referências
            currentExtraRow = newRow;
            currentOpenRow = row;
            
            // Configura evento de clique fora para fechar
            setTimeout(() => {
                const clickOutsideHandler = function(e) {
                    // Verifica se o clique foi fora da linha original e fora do dropdown
                    const isClickOnRow = row.contains(e.target);
                    const isClickOnDropdown = newRow.contains(e.target);
                    const isClickOnActionsCell = e.target.closest('.actions-cell') === actionsCell;
                    
                    // Se clicou na seta da mesma linha, não fecha (o evento já vai reabrir/fechar)
                    if (isClickOnActionsCell) {
                        return;
                    }
                    
                    if (!isClickOnRow && !isClickOnDropdown) {
                        closeCurrentDropdown();
                        document.removeEventListener('click', clickOutsideHandler);
                    }
                };
                document.addEventListener('click', clickOutsideHandler);
            }, 50);
        }
        
        // Handler de clique na seta (célula de ações)
        function handleActionsClick(event) {
            // Se não estiver em mobile, ignorar
            if (!isMobile()) return;
            
            // Impede propagação para evitar conflitos
            event.stopPropagation();
            
            const actionsCell = this;
            const row = actionsCell.closest('tr');
            if (!row) return;
            
            const enfermeiroId = row.getAttribute('data-enfermeiro-id');
            const enfermeiroNome = row.getAttribute('data-enfermeiro-nome') || '';
            
            if (!enfermeiroId) return;
            
            // Verifica se esse mesmo row já tem o dropdown aberto
            if (currentOpenRow === row && currentExtraRow) {
                // Se já está aberto, fecha
                closeCurrentDropdown();
                return;
            }
            
            // Abre o dropdown logo abaixo
            openDropdownBelowRow(row, enfermeiroId, enfermeiroNome);
        }
        
        // Vincula os eventos a todas as células de ações
        function bindActionsEvents() {
            const actionsCells = document.querySelectorAll('.actions-cell');
            actionsCells.forEach(cell => {
                // Remove listener antigo para evitar duplicatas
                cell.removeEventListener('click', handleActionsClick);
                cell.addEventListener('click', handleActionsClick);
            });
        }
        
        // Observa mudanças de orientação/resize para ajustar o estado
        let resizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                if (!isMobile()) {
                    // Se saiu do modo mobile, remove qualquer dropdown pendente
                    closeCurrentDropdown();
                } else {
                    // Se ainda está mobile, reassocia eventos (caso a tabela tenha sido recarregada)
                    bindActionsEvents();
                    // Se houver dropdown aberto, fecha por segurança
                    closeCurrentDropdown();
                }
            }, 200);
        });
        
        // Inicialização: quando o DOM estiver pronto
        function init() {
            bindActionsEvents();
        }
        
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', init);
        } else {
            init();
        }
        
        // Delegação de eventos para os botões "Apagar" gerados dinamicamente
        document.body.addEventListener('click', function(e) {
            const deleteBtn = e.target.closest('.btn-del');
            if (deleteBtn && deleteBtn.getAttribute('data-bs-toggle') === 'modal') {
                // O script dialogo.js usa o atributo data-enfermeiro para preencher o modal
                // O modal será aberto pelo Bootstrap automaticamente
            }
        });
        
        // Fecha dropdown após clicar em qualquer botão de ação
        document.body.addEventListener('click', function(e) {
            const actionBtn = e.target.closest('.btn-act');
            if (actionBtn && isMobile() && !e.target.closest('.dropdown-arrow-icon')) {
                setTimeout(() => {
                    closeCurrentDropdown();
                }, 150);
            }
        });
    })();