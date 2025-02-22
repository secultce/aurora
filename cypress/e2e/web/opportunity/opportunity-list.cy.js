describe('Página de listar Oportunidades', () => {
    beforeEach(() => {
        cy.viewport(1920, 1080);
        cy.visit('/oportunidades');
    })

    it('Garante que a página de lista de oportunidades existe', () => {
        cy.get('a.name-one').contains('Início').should('be.visible');
        cy.get('a.name-one').contains('Oportunidades').should('be.visible');
        cy.get('h2').contains('Oportunidades').should('be.visible');
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
        cy.get('.align-items-end > .fw-bold').contains('10 Oportunidades Encontradas').should('be.visible');

        cy.get(':nth-child(2) > .opportunity-card-header > .flex-wrap > :nth-child(1) > .fw-bold').should('be.visible');
        cy.get(':nth-child(2) > .opportunity-card-header > .flex-wrap > .flex-row-reverse > span').should('be.visible');
        cy.get(':nth-child(2) > .opportunity-card-header > .flex-column > .fw-bold').contains('Edital para Seleção de Artistas de Rua - Circuito Cultural Nordestino').should('be.visible');
        cy.get(':nth-child(2) .opportunity-card-content > .mb-2 > .text-danger').contains('TESTE').should('be.visible');
        cy.get(':nth-child(2) .opportunity-card-content > .mb-2 > .text-primary').contains('Associação dos Pescadores').should('be.visible');
        cy.get(':nth-child(2) .opportunity-card-content > .text-orange.fw-bold').contains('Inscrições de 01/01/2001 à 31/01/2001').should('be.visible');
        cy.get(':nth-child(2) .opportunity-card-content > p').contains('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua...').should('be.visible');
        cy.get(':nth-child(2) > .flex-column.flex-md-row > .opportunity-card-content > :nth-child(4) > .text-orange').contains('Pesca, Antropologia, Ciências Ocultas').should('be.visible');
        cy.get(':nth-child(2) > .flex-column.flex-md-row > .opportunity-card-content > :nth-child(5) > .text-orange').contains('Pesca, Antropologia, Ciências Oculta').should('be.visible');
        cy.get(':nth-child(2) > .justify-content-between > :nth-child(2) > .btn').contains('Acessar').should('be.visible');
    });

    it('Garante que o filtro funciona', () => {
        cy.get('#open-filter').click();
        cy.get('#opportunity-name').type('Edital para Seleção de Artistas de Rua - Circuito Cultural Nordestino');
        cy.get('#apply-filters').click();
        cy.get('.align-items-end > .fw-bold').contains('1 Oportunidades Encontradas').should('be.visible');
        cy.get(':nth-child(2) > .opportunity-card-header > .flex-column > .fw-bold').contains('Edital para Seleção de Artistas de Rua - Circuito Cultural Nordestino').should('be.visible');
    });

    it('Garante que o botão de limpar filtros funciona', () => {
        cy.get('.align-items-end > .fw-bold').contains('10 Oportunidades Encontradas').should('be.visible');
        cy.get('#open-filter').click();
        cy.get('#opportunity-name').type('Edital para Seleção de Artistas de Rua - Circuito Cultural Nordestino');
        cy.get('#apply-filters').click();
        cy.get('.align-items-end > .fw-bold').contains('1 Oportunidades Encontradas').should('be.visible');
        cy.get('#open-filter').click();
        cy.get('#filter-sidebar .btn-outline-primary').contains('Limpar todos os filtros').click();
        cy.get('.align-items-end > .fw-bold').contains('10 Oportunidades Encontradas').should('be.visible');
    });

    it('Garante que as opções de ordenar funcionam', () => {
        cy.get('#order-select')
            .should('exist')
            .should('be.visible');
        cy.get('#order-select')
            .select('Mais Recente')
            .should('have.value', 'DESC');
        cy.get('#order-select')
            .select('Mais Antigo')
            .should('have.value', 'ASC');
    });
})
