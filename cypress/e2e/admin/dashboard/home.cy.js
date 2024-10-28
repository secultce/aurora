describe('Painel de Controle', () => {
    beforeEach(() => {
        cy.viewport(1920, 1080);
        cy.login('talysonsoares@example.com', 'Aurora@2024');
        cy.visit('/painel');
    });

    it('Garante que o Painel de Controle existe', () => {
        cy.get('.fs-2').contains('Painel de Controle').should('be.visible');
        cy.get('.user-info > .fs-4').contains('Talyson').should('be.visible');
    });

    it('Garante que o Painel de Controle tenha as informações das entidades', () => {
        cy.get('.dashboard-cards > :nth-child(1)').contains('10 Agentes').should('be.visible');
        cy.get('.dashboard-cards > :nth-child(2)').contains('10 Oportunidades').should('be.visible');
        cy.get('.dashboard-cards > :nth-child(3)').contains('10 Eventos').should('be.visible');
        cy.get('.dashboard-cards > :nth-child(4)').contains('10 Espaços').should('be.visible');
        cy.get('.dashboard-cards > :nth-child(5)').contains('10 Iniciativas').should('be.visible');
    });

    it('Garante que as inscrições recentes estão visíveis', () => {
        cy.get('.mt-5 > .fs-4').contains('Inscrições recentes').should('be.visible');
        cy.get('.registration-info').contains('Programa de Residências e Intercâmbios Porto Dragão - 2ª Edição // CONVOCATÓRIA 2022').should('be.visible');
        cy.get('.recent-registrations-card > a').contains('Acompanhar').should('be.visible');
    });
})
