describe('Página de listar Oportunidades', () => {
    beforeEach(() => {
        cy.viewport(1920, 1080);
        cy.visit('/oportunidades');
    })

    it('Garante que a página de lista de oportunidades existe', () => {
        cy.get('span.name-one').contains('Início').should('be.visible');
        cy.get('span.name-one').contains('Oportunidades').should('be.visible');
        cy.get('h2.page-title').contains('Oportunidades').should('be.visible');
    });

    it('Garante que o dashboard de oportunidades esteja presente', () => {
        cy.get('.entity-dashboard').should('be.visible');

        const expectedTexts = [
            'Oportunidades Encontradas',
            'Oportunidades em Andamento',
            'Oportunidades Finalizadas',
            'Registradas nos últimos 7 dias',
        ];

        expectedTexts.forEach(text => {
            cy.get('span.text').contains(text).should('be.visible');
        });
    });

    it('Garante que as tabs estão funcionando', () => {
        const tabs = [
            { tab: '#pills-list-tab'},
            { tab: '#pills-map-tab'},
        ];

        tabs.forEach(({ tab }) => {
            cy.get(tab).click();
            cy.get(tab).should('have.class', 'active');
        });
    });

    it('Garante que os cards de oportunidades estão visíveis', () => {
        cy.get('.align-items-end > .fw-bold').contains('182 Oportunidades Encontradas').should('be.visible');
        cy.get('.text-nowrap').contains('Ordenar por').should('be.visible');
        cy.get('#sort-options').select('recent').should('have.value', 'recent');
        cy.get('#sort-options').select('old').should('have.value', 'old');


        cy.get(':nth-child(2) > .opportunity-card-header > .mt-1 > .fw-bold').should('be.visible');
        cy.get(':nth-child(2) > .opportunity-card-header > .justify-content-end > :nth-child(3)').should('be.visible');
        cy.get(':nth-child(2) > .opportunity-card-header > .mt-1 > .fw-bold').contains('Edital para Seleção de Artistas de Rua - Circuito Cultural Nordestino').should('be.visible');
        cy.get(':nth-child(2) > .opportunity-card-header > .mb-2 > .text-danger').contains('TESTE').should('be.visible');
        cy.get(':nth-child(2) > .opportunity-card-header > .mb-2 > entidade > .text-primary').contains('Associação dos Pescadores').should('be.visible');
        cy.get(':nth-child(2) > .opportunity-card-header > .text-orange.fw-bold').contains('Inscrições de 01/01/2001 à 31/01/2001').should('be.visible');
        cy.get(':nth-child(2) > .opportunity-card-header > :nth-child(5)').contains('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua...').should('be.visible');
        cy.get(':nth-child(2) > .opportunity-card-header > :nth-child(6) > .text-orange').contains('Pesca, Antropologia, Ciencias Ocultas').should('be.visible');
        cy.get(':nth-child(3) > .opportunity-card-header > .mt-2 > .text-orange').contains('Pesca, Antropologia, Ciencias Oculta').should('be.visible');
        cy.get(':nth-child(2) > .justify-content-between > :nth-child(2) > .btn').contains('Acessar').should('be.visible');
    });
})
