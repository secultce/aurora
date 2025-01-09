describe('Painel de Controle - Página de timeline dos Espaços', () => {
    beforeEach(() => {
        cy.viewport(1920, 1080);
        cy.login('alessandrofeitoza@example.com', 'Aurora@2024');
        cy.visit('/painel/espacos/69461af3-52f2-4c6b-ad30-ce92e478e9bd/timeline');
    });

    it('Garante que a página de timeline dos espaços existe', () => {
        cy.get('h2').contains('Espaços - SECULT - Timeline').should('be.visible');
        cy.get('.d-flex > div > .btn').contains('Voltar').should('be.visible');

        cy.get('tr > :nth-child(1) > a').contains('The resource was created').should('be.visible');
        cy.get('tbody > tr > :nth-child(2)').contains(/\d{2}\/\d{2}\/\d{4}/).should('be.visible');
        cy.get('tbody > tr > :nth-child(3)').contains('unknown').should('be.visible');

        // Garante que o modal com os detalhes da timeline existe
        cy.get('tbody > :nth-child(2) .btn').contains('Detalhes').click();
        cy.get('.modal-body > .table > thead').contains('De');
        cy.get('.modal-body > .table > thead').contains('Para');
        cy.get('#modal-timeline-table-body > :nth-child(2) > :nth-child(2)').contains('SECULT');
    });
});
