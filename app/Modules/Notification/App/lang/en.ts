// Define a type for the imported JSON modules
type LangFileModule = {
  default: any;
};

// Import the JSON files using import.meta.glob
const langPathFile = import.meta.glob('./en/**/*.json', { eager: true }) as Record<string, LangFileModule>;

// Initialize an empty object to hold the nested keys and values
let translations: Record<string, any> = {};

// Utility function to set a nested value in an object based on a path array
function setValueByPathArray(object: Record<string, any>, path: string[], value: any): void {
  let reference = object;
  for (let i = 0; i < path.length - 1; i++) {
    const currentPath = path[i];
    if (!reference[currentPath]) {
      reference[currentPath] = {};
    }
    reference = reference[currentPath];
  }
  const lastPath = path[path.length - 1];
  reference[lastPath] = value;
}

// Utility function to format the component path into nested keys
function formatComponentPath(componentPath: string): string[] {
  const key = componentPath
      .replace('./en/', '') // Remove the base path
      .replace('.json', ''); // Remove the file extension

  return key.replace(/\//g, '.').split('.');
}

// Process each imported JSON module and set the values in the translations object
function processLangContext(
    context: Record<string, LangFileModule>
): Record<string, any> {
  const result: Record<string, any> = {};

  for (const [componentPath, moduleImport] of Object.entries(context)) {
    const keys = formatComponentPath(componentPath);
    const value = moduleImport.default;

    setValueByPathArray(result, keys, value);
  }

  return result;
}

// Populate the translations object
export default processLangContext(langPathFile);
