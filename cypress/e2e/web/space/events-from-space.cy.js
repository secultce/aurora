describe('Página de listar eventos por espaço', () => {
    beforeEach(() => {
        cy.viewport(1920, 1080);
        cy.visit('/espacos');
        cy.get('#pills-events-tab').click();
        cy.get('#pills-events-tab').should('have.class', 'active');
    });

    it('Garante a grade de eventos', () => {
        cy.get('[data-cy="pills-list-content"] > .justify-content-between > h2').should('be.visible');
        cy.get('[data-cy="pills-list-content"] > .row > :nth-child(1) > .card').should('be.visible');
        cy.get(':nth-child(1) > .card > .p-3 > .text-white').contains('0 participantes');
    });

    it('Garante que as opções de visualização estão presentes', () => {
        cy.get('a').contains('Lista').should('be.visible');
        cy.get('a').contains('Mapa').should('be.visible');
        cy.get('a').contains('Indicadores').should('be.visible');
    });
});
