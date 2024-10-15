describe('Página de listar Selos', () => {
    beforeEach(() => {
        cy.viewport(1920, 1080);
        cy.visit('/painel/selos');
    });

    it('Garante que a página de selos existe', () => {
        cy.get('.management-panel__title').contains('Gestão de Selos').should('be.visible');
        cy.get('.management-panel__action').contains('Criar selo').should('be.visible');
    });

    it('Garante que as tabs estão funcionando', () => {
        const tabs = [
            {tab: '#pills-published-tab'},
            {tab: '#pills-draft-tab'},
            {tab: '#pills-allowed-tab'},
            {tab: '#pills-archived-tab'},
            {tab: '#pills-deleted-tab'}
        ];

        tabs.forEach(({ tab}) => {
            cy.get(tab).click();
            cy.get(tab).should('have.class', 'active');
        })
    });

    it('Garante que o input existe', () => {
        cy.get('#search-seal').should('be.visible');
    })

    it('Garante que os cards estão visíveis', () => {
        cy.get(':nth-child(2) > .seals-header > img').should('be.visible');
        cy.get(':nth-child(2) > .seals-header > img').should('be.visible');
        cy.get(':nth-child(2) > .justify-content-between > .actions-manage > :nth-child(1)').should('be.visible');
        cy.get(':nth-child(2) > .justify-content-between > .actions-manage > :nth-child(2)').should('be.visible');
        cy.get(':nth-child(2) > .justify-content-between > .actions-interact > .seals-edit').should('be.visible');
        cy.get(':nth-child(2) > .justify-content-between > .actions-interact > :nth-child(2)').should('be.visible');
    });
})
