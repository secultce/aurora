describe('Página de listar eventos por espaço', () => {
    beforeEach(() => {
        cy.viewport(1920, 1080);
        cy.visit('/espacos');
        cy.get('#pills-events-tab').click();
        cy.get('#pills-events-tab').should('have.class', 'active');
    });

    it('Garante a grade de eventos', () => {
        cy.get('[data-cy="pills-list-content"] h2').should('be.visible');

        cy.get('#pills-list-sublist-tab').should('have.class', 'active');
        cy.get('#sublist-list').should('have.class', 'active');
        cy.get('#sublist-list .event-card').should('be.visible');

        cy.get('#pills-cards-sublist-tab').click();
        cy.get('#sublist-cards').should('be.visible');
        cy.get('#sublist-cards > .row > .col-md-4').should('be.visible');

        cy.get('#pills-calendar-sublist-tab').should('be.visible');
    });

    it('Garante que as opções de visualização estão presentes', () => {
        cy.get('a').contains('Lista').should('be.visible');
        cy.get('a').contains('Mapa').should('be.visible');
        cy.get('a').contains('Indicadores').should('be.visible');
    });
});
