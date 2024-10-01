describe('Pagina de listar Eventos', () => {
    beforeEach(() => {
        cy.viewport(1920, 1080);
        cy.visit('/eventos');
    })

    it('Garante que a página de lista de eventos existe', () => {
        cy.get('span.name-one').contains('Início').should('be.visible');
        cy.get('span.name-one').contains('Eventos').should('be.visible');
        cy.get('h2.page-title').contains('Eventos').should('be.visible');
        cy.get('button').contains('Criar evento').should('be.visible');
    });

   it('Garante que o dashboard de eventos esteja presente', () => {
        cy.get('.entity-dashboard').should('be.visible');

        const expectedTexts = [
            'Eventos cadastrados',
            'Eventos realizados',
            'Eventos finalizados',
            'Eventos cadastrados nos últimos 7 dias'
        ];

        expectedTexts.forEach(text => {
            cy.get('span.text').contains(text).should('be.visible');
        });
    });
});