import React, { useState } from "react";

function Pagination() {
  const [currentPage, setCurrentPage] = useState(1);
  const totalPages = 6;

  const handleClick = (page: number) => {
    setCurrentPage(page);
  };

  const goToPrevPage = () => {
    if (currentPage > 1) setCurrentPage((prev) => prev - 1);
  };

  const goToNextPage = () => {
    if (currentPage < totalPages) setCurrentPage((prev) => prev + 1);
  };

  return (
    <ul className="flex justify-center gap-1 text-gray-900 mt-3">
      <li>
        <button
          onClick={goToPrevPage}
          className="grid w-10 h-10 place-content-center rounded border border-gray-200 transition-colors hover:bg-gray-50 rtl:rotate-180"
          aria-label="Previous page"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            className="w-4 h-4"
            viewBox="0 0 20 20"
            fill="currentColor"
          >
            <path
              fillRule="evenodd"
              d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
              clipRule="evenodd"
            />
          </svg>
        </button>
      </li>

      {[...Array(totalPages)].map((_, index) => {
        const page = index + 1;
        const isActive = currentPage === page;
        return (
          <li key={page}>
            <button
              onClick={() => handleClick(page)}
              className={`w-10 h-10 rounded border text-center text-sm font-medium transition-colors ${
                isActive
                  ? "border-indigo-600 bg-indigo-600 text-white"
                  : "border-gray-200 hover:bg-gray-50"
              }`}
            >
              {page}
            </button>
          </li>
        );
      })}

      <li>
        <button
          onClick={goToNextPage}
          className="grid w-10 h-10 place-content-center rounded border border-gray-200 transition-colors hover:bg-gray-50 rtl:rotate-180"
          aria-label="Next page"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            className="w-4 h-4"
            viewBox="0 0 20 20"
            fill="currentColor"
          >
            <path
              fillRule="evenodd"
              d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
              clipRule="evenodd"
            />
          </svg>
        </button>
      </li>
    </ul>
  );
}

export default Pagination;
