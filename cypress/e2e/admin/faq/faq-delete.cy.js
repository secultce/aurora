describe('Painel de Controle - Página de listar FAQs', () => {
    beforeEach(() => {
        cy.viewport(1920, 1080);
        cy.login('kellymoura@example.com', 'Aurora@2024');
        cy.visit('/painel/faq');
    });

    it('Garante que a página de FAQs existe', () => {
        cy.get('h2').contains('Minhas FAQs').should('be.visible');
        cy.contains('Quais oportunidades existem para pesquisadores acadêmicos no Brasil?').should('be.visible');
    });

    it('Garante que seja possível deletar uma FAQ', () => {
        cy.get('tbody > tr').last().within(() => {
            cy.contains('Excluir').click();
        });

        cy.get('.modal-dialog', { timeout: 10000 }).should('be.visible');

        cy.get('.modal-dialog').within(() => {
            cy.contains('Confirmar').click();
        });

        cy.get('.success.snackbar').contains('FAQ removida com sucesso.').should('be.visible');
    });
});
