import { ChevronDown } from "lucide-react";
import React, { useEffect } from "react";
import { useTheme } from "../../context/ThemeContext";
import { Grad } from "../../utils/types";

function FilterGrad() {
  const { grads, gradId, setGradId } = useTheme();

  const handleGradChange = (e: React.ChangeEvent<HTMLSelectElement>) => {
    const selectedGradId = parseInt(e.target.value, 10);
    setGradId(selectedGradId);
    console.log("Selected gradId:", selectedGradId); // log the selected ID
  };

  return (
    <div className="relative w-[200px]">
      <select
        className="h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 pr-10 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-none focus:ring-3 focus:ring-brand-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800 cursor-pointer"
        value={gradId}
        onChange={handleGradChange}
      >
        {grads.map((grad) => (
          <option key={grad.id} value={grad.id}>
            {grad.name}
          </option>
        ))}
      </select>
      <span className="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 dark:text-white/60">
        <ChevronDown className="w-4 h-4" />
      </span>
    </div>
  );
}

export default FilterGrad;
