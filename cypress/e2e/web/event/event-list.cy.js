describe('Pagina de listar Eventos', () => {
    beforeEach(() => {
        cy.viewport(1920, 1080);
        cy.visit('/eventos');
    })

    it('Garante que a página de lista de eventos existe', () => {
        cy.get('a.name-one').contains('Início').should('be.visible');
        cy.get('a.name-one').contains('Eventos').should('be.visible');
        cy.get('h2').contains('Eventos').should('be.visible');
        cy.get('a').contains('Criar um evento').should('be.visible');
    });

   it('Garante que o dashboard de eventos esteja presente', () => {
        cy.get('.entity-dashboard').should('be.visible');

        const expectedTexts = [
            'Eventos Encontrados',
            'Eventos em Andamento',
            'Eventos Finalizados',
            'Registrados nos últimos 7 dias'
        ];

        expectedTexts.forEach(text => {
            cy.get('span.text').contains(text).should('be.visible');
        });
   });

    it('Garante que as tabs estão funcionando', () => {
        const tabs = [
            { tab: '#pills-list-tab'},
            { tab: '#pills-calendar-tab'},
            { tab: '#pills-map-tab'},
            { tab: '#pills-indicators-tab'}
        ];

        tabs.forEach(({ tab }) => {
            cy.get(tab).click();
            cy.get(tab).should('have.class', 'active');
        });
    });

    it('Garante que o conteúdo da tab Lista está visível', () => {
        cy.get('#pills-list-tab').click();
        cy.get('#pills-list-tab').should('have.class', 'active');
        cy.get('#pills-list > #scroll-container > [data-cy=pills-list-content]').should('be.visible');

        cy.get('.total-events').contains(/^\d+ Eventos Encontrados/).should('be.visible');
        cy.get('.justify-content-between > .d-flex').contains('Ordenar por').should('be.visible');
        cy.get('#sort-options').select('recent').should('have.value', 'recent');
        cy.get('#sort-options').select('old').should('have.value', 'old');


        cy.get(':nth-child(2) > .event-card-header > .d-flex > .ms-0 > .event-name').contains('Nordeste Literário').should('be.visible');

        // TODO: Aguardando uma issue para ajustar o teste
        // cy.get(':nth-child(2) > .event-card-header > .d-flex > .rounded-circle').should('be.visible');
        // cy.get(':nth-child(2) > .event-card-header > .event-id').contains('ID: 9f0e3630-f9e1-42ca-8e6b-b1dcaa006797').should('be.visible');
        // cy.get(':nth-child(2) > .event-card-header > .d-flex > .ms-3 > .event-name').contains('Nordeste Literário').should('be.visible');
        // cy.get(':nth-child(2) > .event-card-header > .d-flex > .ms-3 > .event-subtitle').contains('Subtítulo do evento').should('be.visible');
        // cy.get(':nth-child(2) > .event-card-body > .event-date').contains('Data e hora não definidas').should('be.visible');
        // cy.get(':nth-child(2) > .event-card-body > .event-location').contains('Casa do Sertão | SCTS – Zona Cívico Administrativa – Brasília/DF – CEP: 70070-150').should('be.visible');
        // cy.get(':nth-child(2) > .event-card-body > .event-languages').contains('Idioma (3): LINGUAGEM, LINGUAGEM, LINGUAGEM').should('be.visible');
        // cy.get(':nth-child(2) > .event-card-body > .event-details').contains( 'Valor da entrada:').should('be.visible');
        // cy.get(':nth-child(2) > .event-card-body > .event-details').contains( 'Número de participantes:').should('be.visible');
        // cy.get(':nth-child(2) > .event-card-body > .event-seals').contains('Selos:').should('be.visible');
        // cy.get(':nth-child(2) > .event-card-body > .text-end').contains('Acessar').should('be.visible');
    });

    it('Garante que o filtro funciona', () => {
        cy.get('#open-filter').click();
        cy.get('#event-name').type('Festival da Rapadura');
        cy.get('#apply-filters').click();
        cy.get('.total-events').contains('1 Eventos Encontrados').should('be.visible');
        cy.get('.event-name').contains('Festival da Rapadura').should('be.visible');
    });

    it('Garante que o botão de limpar filtros funciona', () => {
        cy.get('#open-filter').click();
        cy.get('#event-name').type('Festival da Rapadura');
        cy.get('.total-events').contains(/^\d+ Eventos Encontrados/).should('be.visible');
        cy.get('#apply-filters').click();
        cy.get('.total-events').contains('1 Eventos Encontrados').should('be.visible');
        cy.get('#open-filter').click();
        cy.get('.btn-outline-primary').click();
        cy.get('.total-events').contains(/^\d+ Eventos Encontrados/).should('be.visible');
    });
});
