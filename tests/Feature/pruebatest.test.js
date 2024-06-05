import {  describe, expect, test } from 'vitest';

import axios from 'axios';

describe('Prueba de la ruta /api/allrestaurants', () => {
  test('debería devolver todos los restaurantes', async () => {
    // Realizar una solicitud HTTP a la ruta /api/allrestaurants
    const response = await axios.get('/api/allrestaurants');

    // Verificar que la solicitud fue exitosa (código de respuesta 200)
    expect(response.status).toBe(200);

    // Verificar que la respuesta es un JSON
    expect(response.headers['content-type']).toContain('application/json');

    // Verificar que la respuesta contiene datos de restaurantes
    expect(response.data.length).toBeGreaterThan(0); // Verifica que haya al menos un restaurante devuelto
  });
});
