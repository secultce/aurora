describe('Página de Home do ambiente web', () => {
    beforeEach(() => {
        cy.viewport(1920, 1080);
        cy.visit('/');
    });

    const entities = [
        { name: 'Oportunidades', path: '/admin_opportunity_opportunity' },
        { name: 'Eventos', path: '/admin_event_event' },
        { name: 'Espaços', path: '/admin_space_space' },
        { name: 'Agentes', path: '/admin_agent_agent' },
        { name: 'Iniciativas', path: '/admin_initiative_initiative' }
    ];

    it('Garante que o navbar existe', () => {
        const entityNames = entities.map(entity => entity.name);
        entityNames.forEach((entity) => {
            cy.get('a').contains(entity).should('be.visible');
        });
    });

    it('Clica no ícone de Oportunidades e garante o redirecionamento', () => {
        cy.get('a.nav-link.opportunity').should('be.visible').and('not.be.disabled').click({ force: true });
        cy.url().should('include', '/oportunidades');
    });

    it('Clica no ícone de Agentes e garante o redirecionamento', () => {
        cy.get('a.nav-link.agent').should('be.visible').and('not.be.disabled').click({ force: true });
        cy.url().should('include', '/agentes');
    });

    it('Clica no ícone de Eventos e garante o redirecionamento', () => {
        cy.get('a.nav-link.event').should('be.visible').and('not.be.disabled').click({ force: true });
        cy.url().should('include', '/eventos');
    });

    it('Clica no ícone de Espaços e garante o redirecionamento', () => {
        cy.get('a.nav-link.space').should('be.visible').and('not.be.disabled').click({ force: true });
        cy.url().should('include', '/espacos');
    });

    it('Clica no ícone de Iniciativas e garante o redirecionamento', () => {
        cy.contains('a', 'Iniciativas').should('be.visible').click({ force: true });
        cy.url().should('include', '/iniciativas');
    });
});
