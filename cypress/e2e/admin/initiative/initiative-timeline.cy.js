describe('Painel de Controle - Página de timeline das Iniciativas', () => {
    beforeEach(() => {
        cy.viewport(1920, 1080);
        cy.login('alessandrofeitoza@example.com', 'Aurora@2024');
        cy.visit('painel/iniciativas/');
    });

    it('Garante que a página de timeline da Iniciativa existe', () => {
        cy.get('[data-cy="f0774ecd-4860-4b8c-9607-32090dc31f71"]').contains('Timeline').click({force: true});

        cy.get('h2').contains('Iniciativa - Vozes do Sertão - Timeline').should('be.visible');
        cy.get('.d-flex > div > .btn').contains('Voltar').should('be.visible');

        cy.get('tr > :nth-child(1) > a').contains('A entidade foi criada').should('be.visible');
        cy.get('tbody > tr > :nth-child(2)').contains(/\d{2}\/\d{2}\/\d{4}/).should('be.visible');
        cy.get('tbody > tr > :nth-child(3)').contains('unknown').should('be.visible');
        cy.get(':nth-child(5) > .btn').contains('Detalhes').should('be.visible')
    });

    it('Garante que o modal com os detalhes da timeline existe', () => {
        cy.get('[data-cy="f0774ecd-4860-4b8c-9607-32090dc31f71"] > :nth-child(5) > .btn-outline-info').click();
        cy.get(':nth-child(2) > :nth-child(5) > .btn').click();
        cy.get('.modal-body > .table > thead > tr > :nth-child(2)').contains('De');
        cy.get('.modal-body > .table > thead > tr > :nth-child(3)').contains('Para');
        cy.get('#modal-timeline-table-body > :nth-child(2) > :nth-child(2)').contains('Voz');
        cy.get('#modal-timeline-table-body > :nth-child(2) > :nth-child(3)').contains('Vozes do Sertão');
    });
});
