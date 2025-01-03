describe('Painel de Controle - Página de listar Iniciativas', () => {
    beforeEach(() => {
        cy.viewport(1920, 1080);
        cy.login('alessandrofeitoza@example.com', 'Aurora@2024');
        cy.visit('painel/iniciativas/f0774ecd-4860-4b8c-9607-32090dc31f71/timeline');
    });

    it('Garante que a página de timeline existe', () => {
        cy.get('h2').contains('Iniciativa - Vozes do Sertão - Timeline').should('be.visible');
        cy.get('.d-flex > div > .btn').contains('Voltar').should('be.visible');
    });

    it('Garante que os dados da iniciativa estão visíveis', () => {
        cy.get('tr > :nth-child(1) > a').contains('The resource was created').should('be.visible');
        cy.get('tbody > tr > :nth-child(2)').contains(/\d{2}\/\d{2}\/\d{4}/).should('be.visible');
        cy.get('tbody > tr > :nth-child(3)').contains('unknown').should('be.visible');
        cy.get(':nth-child(5) > .btn').contains('Detalhes').should('be.visible')
    });
})
