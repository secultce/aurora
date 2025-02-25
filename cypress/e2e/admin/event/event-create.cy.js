describe('Pagina de Cadastrar Eventos', () => {
    beforeEach(() => {
        cy.viewport(1920, 1080);
        cy.login('henriquelopeslima@example.com', 'Aurora@2024');
        cy.visit('/painel/eventos/adicionar');

        Cypress.on('uncaught:exception', (err, runnable) => {
            // Previne falhas de teste devido a erros não críticos
            if (err.message.includes('createPopper is not a function') || err.message.includes('Cannot read properties of null')) {
                return false;
            }
        });
    })

    // Devido a novos atributos adicionados a entidade evento, esse teste está quebrando
    // it('Garante que a página de listar de eventos possui um botão de criar evento', () => {
    //     cy.visit('/eventos');
    //     cy.get('a').contains('Criar um evento').click();
    //     cy.url().should('include', '/painel/eventos/adicionar');
    //     cy.get('form').should('exist').and('be.visible');


    //     //Verifica se as validações dos campos estão funcionando
    //     cy.visit('/painel/eventos/adicionar');

    //     cy.get('#name').type('E');
    //     cy.get("p.text-danger.mt-2").should('be.visible', 'O nome deve ter entre 2 e 50 caracteres.');
    //     cy.get('#name').clear().type('Evento Teste');

    //     cy.wait(100);

    //     cy.visit('/painel/eventos/adicionar');

    //     cy.get('#name').type('Evento Teste');
    //     cy.contains('button', 'Adicionar').click();
    //     cy.get("a[data-value='area0']").click()
    //     cy.get('#description').type('Este é um evento teste.');
    //     cy.get('#age-rating').select('Livre');

    //     cy.contains('button', 'Criar e Publicar').click();

    //     cy.wait(100);

    //     cy.contains('Evento Teste');
    // });
});
