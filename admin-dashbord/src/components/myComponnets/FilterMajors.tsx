import { ChevronDown } from "lucide-react";
import React from "react";
import { useTheme } from "../../context/ThemeContext";
interface FilterMajorsProps {
  selectedMajor: number;
  setSelectedMajor: (grade: number) => void;
  addAllOption?: boolean;
}

function FilterMajors({
  selectedMajor,
  setSelectedMajor,
  addAllOption = true,
}: FilterMajorsProps) {
  const { majors, grads } = useTheme();

  const handleMajorChange = (e: React.ChangeEvent<HTMLSelectElement>) => {
    const selectedMajorId = parseInt(e.target.value, 10);
    setSelectedMajor(selectedMajorId);
    console.log("Selected majorId:", selectedMajorId);
  };
  return (
    <div className="relative w-[250px] text-left">
      <select
        className="h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 pr-10 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-none focus:ring-3 focus:ring-brand-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800 cursor-pointer"
        value={selectedMajor}
        onChange={handleMajorChange}
      >
        {addAllOption ? (
          <option key={-1} value={-1}>
            All
          </option>
        ) : (
          <></>
        )}

        {grads
          .filter((g) => g.id !== -1)
          .map((grad) => (
            <optgroup key={grad.id} label={grad.name}>
              {majors
                .filter((major) => major.grade.id === grad.id)
                .map((major) => (
                  <option key={major.id} value={major.id}>
                    {major.name}
                  </option>
                ))}
            </optgroup>
          ))}
      </select>
      <span className="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 dark:text-white/60">
        <ChevronDown className="w-4 h-4" />
      </span>
    </div>
  );
}

export default FilterMajors;
