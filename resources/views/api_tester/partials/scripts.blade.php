@push('scripts')
<script>
function sendRequest(method) {
    const token = document.getElementById('api_token').value.trim();
    const url = document.getElementById('api_url').value.trim();
    const jsonBody = document.getElementById('json_body').value.trim();
    const locale = document.getElementById('current_locale').value;
    const responseElement = document.getElementById('response');

    // Validate inputs
    if (!token) {
        responseElement.textContent = locale === 'es' ? 'Error: Se requiere el token de API' : 'Error: API Token is required';
        return;
    }

    if (!url) {
        responseElement.textContent = locale === 'es' ? 'Error: Se requiere la URL de API' : 'Error: API URL is required';
        return;
    }

    // Show loading
    responseElement.textContent = locale === 'es' ? 'Cargando...' : 'Loading...';

    // Prepare request options
    let requestMethod = method;

    // Special handling for deleteSave endpoint - always use POST
    if (url.includes('/deleteSave')) {
        requestMethod = 'POST';
    }

    const requestOptions = {
        method: requestMethod,
        headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + token,
            'Accept-Language': locale
        }
    };

    // Add body for POST, PUT, PATCH methods
    if (['POST', 'PUT', 'PATCH'].includes(requestMethod) && jsonBody) {
        try {
            JSON.parse(jsonBody); // Validate JSON
            requestOptions.body = jsonBody;
        } catch (e) {
            responseElement.textContent = locale === 'es' ? 'Error: Formato JSON inválido en el cuerpo' : 'Error: Invalid JSON format in body';
            return;
        }
    }

    // Make the request
    fetch(url, requestOptions)
        .then(response => {
            const status = response.status;
            const statusText = response.statusText;

            return response.json().then(data => ({
                status: status,
                statusText: statusText,
                data: data
            })).catch(() => ({
                status: status,
                statusText: statusText,
                data: { message: locale === 'es' ? 'La respuesta no es un JSON válido' : 'Response is not valid JSON' }
            }));
        })
        .then(result => {
            const formattedResponse = {
                status: result.status + ' ' + result.statusText,
                method: requestMethod,
                url: url,
                response: result.data
            };
            responseElement.textContent = JSON.stringify(formattedResponse, null, 2);
        })
        .catch(error => {
            responseElement.textContent = (locale === 'es' ? 'Error: ' : 'Error: ') + error.message;
        });
}

// Helper function to set common endpoints
function setEndpoint(endpoint) {
    document.getElementById('api_url').value = endpoint;
}

// Helper function to set common JSON bodies
function setJsonBody(jsonString) {
    document.getElementById('json_body').value = jsonString;
}

// Quick action functions
function quickList() {
    setEndpoint('/api/languages');
    setJsonBody('');
}

function quickCreate() {
    setEndpoint('/api/languages');
    setJsonBody('{\n  "name": "Test Language",\n  "iso_code": "tl"\n}');
}

function quickUpdate() {
    setEndpoint('/api/languages/SLUG');
    setJsonBody('{\n  "name": "Updated Language",\n  "iso_code": "ul",\n  "is_active": true\n}');
}

function quickDelete() {
    setEndpoint('/api/languages/SLUG/deleteSave');
    setJsonBody('{\n  "deleted_description": "Test deletion reason"\n}');
}

// Initialize with common examples
document.addEventListener('DOMContentLoaded', function() {
    // Page is ready, no dynamic DOM manipulation needed
});
</script>
@endpush