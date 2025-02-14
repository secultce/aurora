describe('Página de Listar de Organizações', () => {
    beforeEach(() => {
        cy.viewport(1920, 1080);
        cy.visit('/organizacoes');
    });

    it('Garante que a página de lista de organizações existe', () => {
        cy.get('.breadcrumb a:nth-child(1)').contains('Início').should('be.visible');
        cy.get('.breadcrumb a:nth-child(2)').contains('Organizações').should('be.visible');
        cy.get('.page-title').contains('Organizações').should('be.visible');
        cy.contains('Organizações Encontradas');
    });

    it('Garante que o dashboard de organizações esteja presente', () => {
        cy.get('.entity-dashboard').should('be.visible');

        const expectedTexts = [
            'Organizações Encontradas',
            'Organizações Culturais',
            'Organizações Inativos',
            'Registrados nos últimos 7 dias'
        ];

        expectedTexts.forEach(text => {
            cy.get('span.text').contains(text).should('be.visible');
        });
    });

    it('Garante que as tabs estão funcionando', () => {
        const tabs = [
            { tab: '#pills-list-tab' },
            { tab: '#pills-map-tab' },
            { tab: '#pills-indicators-tab' }
        ];

        tabs.forEach(({ tab }) => {
            cy.get(tab).click();
            cy.get(tab).should('have.class', 'active');
        });
    });

    it('Garante que os cards de organizações estão visíveis', () => {
        cy.get('.align-items-end > .fw-bold').contains(/^\d+ Organizações Encontradas/).should('be.visible');
        cy.get('#order-select').should('exist').should('be.visible');

        cy.get('.organization-name').first().should('be.visible');
    });

    it('Garante que o filtro de ordenação funciona', () => {
        cy.get(':nth-child(2) > .gap-3 > .d-flex > .organization-name').contains('Banda de Forró tô nem veno').should('be.visible');
        cy.get('#order-select').select('Mais Recente');
        cy.get(':nth-child(2) > .gap-3 > .d-flex > .organization-name').contains('PHP com Rapadura').should('be.visible');
        cy.get('#order-select').select('Mais Antigo');
        cy.get(':nth-child(2) > .gap-3 > .d-flex > .organization-name').contains('Banda de Forró tô nem veno').should('be.visible');
    });

    it('Garante que o filtro funciona', () => {
        cy.get('#open-filter').click();
        cy.get('#organization-name').type('PHPeste');
        cy.get('#apply-filters').click();
        cy.get('.align-items-end > .fw-bold').contains('1 Organizações Encontradas').should('be.visible');
        cy.get('.organization-name').contains('PHPeste').should('be.visible');
    });

    it('Garante que o botão de limpar filtros funciona', () => {
        cy.get('.align-items-end > .fw-bold').invoke('text').then((initialCount) => {
            cy.get('#open-filter').click();
            cy.get('#organization-name').type('PHPeste');
            cy.get('#apply-filters').click();
            cy.get('.align-items-end > .fw-bold').contains('1 Organizações Encontradas').should('be.visible');

            cy.get('#open-filter').click();
            cy.get('.btn-outline-primary').click();
            cy.get('.align-items-end > .fw-bold').invoke('text').should((finalCount) => {
                expect(finalCount).to.eq(initialCount);
            });
        });
    });
});
