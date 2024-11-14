describe('Painel de Controle - Página de criar Iniciativas', () => {
    beforeEach(() => {
        cy.viewport(1920, 1080);
        cy.login('alessandrofeitoza@example.com', 'Aurora@2024');
        cy.visit('/painel/iniciativas/adicionar');
    });

    it('Garante que a página de criar Iniciativa existe', () => {
        cy.get('h2').contains('Criar uma iniciativa').should('be.visible');
    });

    it('Garante que os campos para criar uma iniciativa existem', () => {
        cy.get('[data-cy="name"]').should('be.visible');
        cy.get('[data-cy="culturalLanguage"]').should('be.visible');
        cy.get('[data-cy="areasOfExpertise"]').should('be.visible');
        cy.get('[data-cy="createdBy"]').should('be.visible');
        cy.get('[data-cy="coverImage"]').should('be.visible');
        cy.get('[data-cy="shortDescription"]').should('be.visible');
        cy.get('[data-cy="longDescription"]').should('be.visible');
    });

    it('Garante que as validações dos campos estão funcionando', () => {
        cy.get('[data-cy="submit"]').click();

        cy.contains('Preencha todos os campos obrigatórios.').should('be.visible');
    });

    it('Garante que os botões da página existem', () => {
        cy.get('button').contains('Criar e Publicar').should('exist');
        cy.get('button').contains('Criar em Rascunho').should('exist');
        cy.get('a').contains('Cancelar').should('exist');
    });

    it('Garante que após o cadastro será redirecionado para a página de listagem', () => {
        cy.get('[data-cy="name"]').type('Baião de Dez');
        cy.get('[data-cy="createdBy"]').select('0cc8c682-b0cd-4cb3-bd9d-41a9161b3566');

        cy.get('[data-cy="submit"]').click();

        cy.contains('A Iniciativa foi criada com sucesso').should('be.visible');
    });
})
