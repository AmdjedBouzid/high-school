import { useEffect, useState } from "react";
import Label from "../../form/Label";
import Input from "../../form/input/InputField";
import Button from "../button/Button";
import { ChevronDown } from "lucide-react";
import { toast } from "react-toastify";
import { useTheme } from "../../../context/ThemeContext";
import axiosInstance from "../../../utils/Interceptor";
import Loader from "../../myComponnets/Loader";
import FilterMajors from "../../myComponnets/FilterMajors";
interface closeModalProps {
  closeModal1: () => void;
  action: "add" | "edit";
  confirmationItemId?: number;
}

function AddSectionModal({
  closeModal1,
  action,
  confirmationItemId,
}: closeModalProps) {
  const { majors, setMajors, sections, setSections } = useTheme();
  const [loading, setLoading] = useState(false);

  const [majorId, setMajorId] = useState<number>(1);
  const [sectionName, setSectionName] = useState<string>("");

  const handleSave = async () => {
    try {
      setLoading(true);
      let formData: any = {};

      if (action === "add") {
        formData = {
          name: sectionName,
          major_id: majorId,
        };

        const response = await axiosInstance.post("/sections", formData);
        if (response.status === 201) {
          const responseData = response.data as any;
          const newSection = responseData.data;
          setSections((prev) => [...prev, newSection]);
        }
      } else {
        if (majorId) formData.grade_id = majorId;
        if (sectionName) formData.name = sectionName;

        const response = await axiosInstance.patch(
          `/majors/${confirmationItemId}`,
          formData
        );

        if (response.status === 200) {
          const updatedMajor = (response.data as any).data;
          const updatedMajors = majors.map((major) =>
            major.id === updatedMajor.id ? updatedMajor : major
          );
          setMajors(updatedMajors);
        }
      }

      closeModal1();
    } catch (error: any) {
      setLoading(false);
      closeModal1();
      toast.error(error.response?.data?.message || "Failed to update major.");
    }
  };

  return (
    <div className="no-scrollbar relative w-full max-w-[700px] overflow-y-auto rounded-3xl bg-white p-4 dark:bg-gray-900 lg:p-11 ">
      <div className="px-2 pr-14">
        <h4 className="mb-2 text-2xl font-semibold text-gray-800 dark:text-white/90">
          {action === "add" ? "Add New Supervisor" : "Edit Supervisor"}
        </h4>
        <p className="mb-6 text-sm text-gray-500 dark:text-gray-400 lg:mb-7">
          {action === "add"
            ? "all inputs are required"
            : "all inputs are not required"}
        </p>
      </div>
      <div className="flex flex-col">
        <div className="custom-scrollbar h-[350px] overflow-y-auto px-2 pb-3">
          <div className="mt-7">
            <div className="w- full flex justify-between wrap items-center gap-4">
              <div className="col-span-2 lg:col-span-1 ">
                <Label>Section Name</Label>
                <Input
                  type="text"
                  value={sectionName}
                  onChange={(e) => setSectionName(e.target.value)}
                />
              </div>
              <div>
                {" "}
                <Label>Section Name</Label>
                <FilterMajors
                  selectedMajor={majorId}
                  setSelectedMajor={setMajorId}
                  addAllOption={false}
                />
              </div>
            </div>
          </div>
        </div>
        <div className="flex items-center gap-3 px-2 mt-6 justify-end">
          <Button
            size="sm"
            variant="outline"
            onClick={closeModal1}
            disabled={loading}
          >
            Close
          </Button>
          <Button size="sm" onClick={handleSave} disabled={loading}>
            {loading ? <Loader /> : action === "add" ? "Add" : "Update"}
          </Button>
        </div>
      </div>
    </div>
  );
}

export default AddSectionModal;
