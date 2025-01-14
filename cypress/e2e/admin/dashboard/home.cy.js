describe('Painel de Controle', () => {
    beforeEach(() => {
        cy.viewport(1920, 1080);
        cy.login('talysonsoares@example.com', 'Aurora@2024');
        cy.visit('/painel');
    });

    it('Garante que o Painel de Controle existe', () => {
        cy.get('.fs-2').contains('Painel de Controle').should('be.visible');
        cy.get('.user-info > .fs-4').contains('Talyson').should('be.visible');

        cy.get('[data-cy=agent-card-dashboard]').contains('1 Agentes').should('be.visible');
        cy.get('[data-cy=event-card-dashboard]').contains('Eventos').should('be.visible');
        cy.get('[data-cy=space-card-dashboard]').contains('Espaços').should('be.visible');
        cy.get('[data-cy=opportunity-card-dashboard]').contains('1 Oportunidades').should('be.visible');
        cy.get('[data-cy=initiative-card-dashboard]').contains('0 Iniciativas').should('be.visible');

        cy.get('.mt-5 > .fs-4').contains('Inscrições recentes').should('be.visible');
        cy.get('.registration-info').contains('Programa de Residências e Intercâmbios Porto Dragão - 2ª Edição // CONVOCATÓRIA 2022').should('be.visible');
        cy.get('.recent-registrations-card > a').contains('Acompanhar').should('be.visible');
    });

    it('Garante que os botões de "Criar" em cada entidade do dashboard estão funcionando e fazendo o redirecionamento correto', () => {
        const entities = [
            { dataCy: 'agent-card-dashboard', route: 'painel/agentes/adicionar' },
            { dataCy: 'event-card-dashboard', route: 'painel/eventos/adicionar' },
            { dataCy: 'space-card-dashboard', route: 'painel/espacos/adicionar' },
            { dataCy: 'opportunity-card-dashboard', route: 'painel/oportunidades/adicionar' },
            { dataCy: 'initiative-card-dashboard', route: 'painel/iniciativas/adicionar' }
        ];

        entities.forEach(entity => {
            cy.get(`div[data-cy='${entity.dataCy}'] a`)
                .click()
                .url()
                .should('include', entity.route);
            cy.contains('Voltar').click();
        });
    });
});
