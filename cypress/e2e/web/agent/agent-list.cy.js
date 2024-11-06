describe('Página de Listar de Agentes', () => {
    beforeEach(() => {
        cy.viewport(1920, 1080);
        cy.visit('/agentes');
    });

    it('Garante que a página de lista de agentes existe', () => {
        cy.get('.breadcrumb a:nth-child(1)').contains('Início').should('be.visible');
        cy.get('.breadcrumb a:nth-child(2)').contains('Agentes').should('be.visible');
        cy.get('.page-title').contains('Agentes').should('be.visible');
        cy.contains('Agentes Encontrados');
    });

    it('Garante que o dashboard de agentes esteja presente', () => {
        cy.get('.entity-dashboard').should('be.visible');

        const expectedTexts = [
            'Agentes Encontrados',
            'Agentes Culturais',
            'Agentes Inativos',
            'Registrados nos últimos 7 dias'
        ];

        expectedTexts.forEach(text => {
            cy.get('span.text').contains(text).should('be.visible');
        });
    });

    it('Garante que as tabs estão funcionando', () => {
        const tabs = [
            { tab: '#pills-list-tab'},
            { tab: '#pills-map-tab'},
            { tab: '#pills-indicators-tab'}
        ];

        tabs.forEach(({ tab }) => {
            cy.get(tab).click();
            cy.get(tab).should('have.class', 'active');
        });
    });

    it('Garante que os cards de agentes estão visíveis', () => {
        cy.get('.align-items-end > .fw-bold').contains('10 Agentes Encontrados').should('be.visible');
        cy.get('.agent-options').should('be.visible');
        cy.get('#sort-options').select('recent').should('have.value', 'recent');
        cy.get('#sort-options').select('old').should('have.value', 'old');

        cy.get(':nth-child(2) > .agent-card-header > .agent-info > .agent-name').contains('Paulo').should('be.visible');
        cy.get(':nth-child(2) > .agent-card-body > .agent-area > .agent-sub-area').contains('DESENVOLVIMENTO').should('be.visible');
        cy.get(':nth-child(2) > .agent-card-body > .agent-location').contains('Goiânia (GO)').should('be.visible');
        cy.get(':nth-child(2) > .agent-card-body > .agent-seals > .seals-area').should('be.visible');
        cy.get(':nth-child(2) > .agent-card-body > .agent-description').contains('Especializado em teológia, organiza exposições por todos o Ceará.').should('be.visible');
        cy.get(':nth-child(2) > .agent-card-body > .access-profile-container > .btn').contains('Acessar').should('be.visible');
    });
});
