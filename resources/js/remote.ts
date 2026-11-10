/** Requests for the ajax selects, shaped like js-utilities' select2-custom.js sent them. */

export type Params = Record<string, unknown>

export type Item = Record<string, unknown>

/** Appends params to a URL the way jQuery's `$.param()` does: `filter[search]=x`, `ids[]=1`. */
export function withQuery(url: string, params: Params): string {
  const search = new URLSearchParams()

  const add = (key: string, value: unknown): void => {
    if (Array.isArray(value)) {
      value.forEach((item) => add(`${key}[]`, item))
    } else if (value !== null && typeof value === "object") {
      Object.entries(value).forEach(([name, item]) => add(`${key}[${name}]`, item))
    } else {
      search.append(key, value === null || value === undefined ? "" : String(value))
    }
  }

  Object.entries(params).forEach(([key, value]) => add(key, value))

  const query = search.toString()

  return query ? `${url}${url.includes("?") ? "&" : "?"}${query}` : url
}

/** GETs JSON like jQuery's `$.ajax({ dataType: "json" })`, with Laravel's ajax headers. */
export async function getJson(url: string, signal?: AbortSignal): Promise<unknown> {
  const response = await fetch(url, {
    headers: { Accept: "application/json", "X-Requested-With": "XMLHttpRequest" },
    credentials: "same-origin",
    signal,
  })

  if (!response.ok) throw new Error(`HTTP ${response.status}`)

  return response.json() as Promise<unknown>
}

/** The items of a plain array or a Laravel paginated response, and whether there's a next page. */
export function itemsOf(body: unknown): { items: Item[]; more: boolean } {
  if (Array.isArray(body)) return { items: body as Item[], more: false }

  if (body && typeof body === "object") {
    const page = body as { data?: unknown; next_page_url?: unknown }
    const items = Array.isArray(page.data) ? (page.data as Item[]) : []

    return { items, more: page.next_page_url !== null && page.next_page_url !== undefined }
  }

  return { items: [], more: false }
}

export interface Option {
  value: string
  text: string
}

/** `{ value, text }` options from items, using the select's id and name fields. */
export function toOptions(items: Item[], idField: string, nameField: string): Option[] {
  return items.map((item) => ({ value: String(item[idField] ?? ""), text: String(item[nameField] ?? "") }))
}
